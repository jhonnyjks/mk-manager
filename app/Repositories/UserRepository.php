<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Plan;
use InfyOm\Generator\Common\BaseRepository;
use RouterOS\Config;
use RouterOS\Client;
use RouterOS\Query;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version January 26, 2019, 2:45 am UTC
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'username',
        'password',
        'phone',
        'celphone',
        'cpf_cnpj',
        'user_type_id',
        'plan_id',
        'general_status_id',
        'payment_promise',
        'last_payment',
        'id_hotspot'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function create(array $attributes) 
    {
        // Segurança: se não for admin, só pode add usuario membro (type=3) 
        if(auth()->guest() || (!auth()->guest() && auth()->user()->user_type_id != 1)) {
            $attributes['general_status_id'] = 2;
            $attributes['user_type_id'] = 3;
        }

        if(3 == $attributes['user_type_id']) {
            $API = new RouterosAPI();
            $API->connect('192.168.98.66', 'teste', '123456789');

            $API->comm('/ip/hotspot/user/add', [
                'name' => $attributes['username'],
                'profile' => Plan::find($attributes['plan_id'])->name,
                'password' => $attributes['password'],
                'disabled' => 'yes',
                'server' => 'all'
            ]);

            $hsUser = $API->comm("/ip/hotspot/user/print", ["?name" => $attributes['username']]);

            if(empty($hsUser)) {
                return [];
            }

            $attributes['id_hotspot'] = $hsUser[0]['.id'];
        }

        $attributes['password'] = bcrypt($attributes['password']);
        parent::create($attributes);
    }

    public function update(array $attributes, $id) 
    { 

        // Segurança: se não for admin, só pode add usuario membro (type=3) 
        if(auth()->user()->user_type_id != 1) {

            unset($attributes['user_type_id']);

            if(auth()->user()->user_type_id != 2) {
                unset($attributes['general_status_id']);
            }
        }

        $user = User::find($id);

        $params = [];
        
        if(!empty($attributes['password'])) {
            $params['password'] = $attributes['password'];
            $attributes['password'] = bcrypt($attributes['password']);
        } else {
            $attributes['password'] = $user->password;
        }

        // Se a data de pagamento foi alterada, verifica se deve-se ativar o usuário
        if(!empty($attributes['last_payment']) && date_diff(
            date_create($attributes['last_payment']), date_create(date("Y-m-d")))->days < 31) {

            $params['disabled'] = 'no';
            $attributes['general_status_id'] = 1;
        }

        // Se a data de pagamento foi alterada, verifica se deve-se ativar o usuário
        if(!empty($attributes['plan_id'])) {
            $params['profile'] = Plan::find($attributes['plan_id'])->name;
        }

        if(!empty($params)) {
            $user = User::find($id);

            $params['.id'] = $user->id_hotspot;
            
            $API = new RouterosAPI();
            $API->connect('192.168.98.66', 'teste', '123456789');            
            $API->comm("/ip/hotspot/user/set", $params);

            $hsUser = $API->comm("/ip/hotspot/user/print", ['?.id' => $user->id_hotspot]);

            if(empty($hsUser)) {
                return [];
            }
        }

        return parent::update($attributes, $id);
    }

    public function promisePayment($id) 
    { 

        $user = User::find($id);

        if(!empty($user) && $user->payment_promise < 2) {

            $API = new RouterosAPI();
            $API->connect('192.168.98.66', 'teste', '123456789');

            $API->comm("/ip/hotspot/user/set", [
                ".id" => $user->id_hotspot,
                "disabled" => "no"
            ]);

            $hsUser = $API->comm("/ip/hotspot/user/print", [
              "?.id" => $user->id_hotspot
          ]);

            if(empty($hsUser)) {
                return [];
            }
        } else {
            return [];
        }

        $user->update(['payment_promise' => $user->payment_promise + 1, 'general_status_id' => 1]);
        return $user;
    }


    /**
     * Verifica os pacotes vencidos e desativa as contas. Deve ficar em Scheduller/Cron diário
     **/
    public function updatePaymentSituations() 
    { 
        $API = new RouterosAPI();
        $API->connect('192.168.98.66', 'teste', '123456789');

        $pendingUsers = $this->model
        //Retorna usários com pacotes vencidos em 3 prazos: o normal, uma promessa de pagamento de 3 dias e outra de 6 dias.
        ->where([
            'user_type_id' => 3,
            ['last_payment', '<=', date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'))],
            'general_status_id' => 1,
            'payment_promise' => 0
        ])->orWhere([
            ['user_type_id', '=', 3],
            ['last_payment', '<=', date('Y-m-d', strtotime(date('Y-m-d'). ' - 33 days'))],
            ['general_status_id', '=', 1],
            ['payment_promise', '=', 1]
        ])->orWhere([
            ['user_type_id', '=', 3],
            ['last_payment', '<=', date('Y-m-d', strtotime(date('Y-m-d'). ' - 36 days'))],
            ['general_status_id', '=', 1],
            ['payment_promise', '=', 2]
        ])->get();

        foreach ($pendingUsers as $user) {
            $API->comm("/ip/hotspot/user/set", [
                ".id" => $user->id_hotspot,
                "disabled" => "yes"
            ]);

            $hsUser = $API->comm("/ip/hotspot/user/print", [
                "?.id" => $user->id_hotspot
            ]);

            if(!empty($hsUser) && $user->id_hotspot == $hsUser[0]['.id']) {
                $user->update(['general_status_id' => 2]);
            }
        }

        $rest = $this->model->where([
            'user_type_id' => 3,
            ['last_payment', '<=', date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'))],
            'general_status_id' => 1
        ])->get();

        echo 'Alterados: '.(sizeof($pendingUsers)-sizeof($rest)).'/'.sizeof($pendingUsers);
    }

    /**
     * Carrega o necessário do mikrotik pra base do sistema
     **/
    public function loadDatabase()
    {
        $API = new RouterosAPI();
        $API->connect('192.168.98.66', 'teste', '123456789');

        $profiles = $API->comm("/ip/hotspot/user/profile/print");

        foreach ($profiles as $profile) {
            Plan::updateOrCreate(['id_hotspot' => $profile['.id']], [
                'name' => $profile['name'],
                'shared_users' => $profile['shared-users']
            ]);
        }

        $users = $API->comm("/ip/hotspot/user/print");/*, array(
          //"count-only" => "",
          "?profile" => "$prof",
      ));*/

      $plans = Plan::get()->pluck('id', 'name')->toArray();

      foreach ($users as $user) {

        //TODO: implementar trial user; Implementar gerenciamento de Devices(login by MAC)
        if($user['name'] == 'default-trial' or preg_match('/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/', $user['name']) == 1) continue;

        // if($user['name'] == 'dudu') dd($user['disabled'] == 'true' ? 2 : 1);

        User::updateOrCreate(['id_hotspot' => $user['.id']], [
            'name' => $user['name'],
            'username' => $user['name'],
            'email' => $user['name'].rand(10,99).'@login.net',
            'user_type_id' => 3,
            'password' => bcrypt($user['password']),
            'plan_id' => $plans[$user['profile']],
            'general_status_id' => ($user['disabled'] == 'true' ? 2 : 1)

            //Linha específica para meu padrão de definir último pag no comment. Ex.: Primeiro_acesso-jul/25/2017,-- Nao pagou o mes
            //,'last_payment' => (strlen($user['comment']) > 26 ? date('Y-m-d', strtotime(str_replace('/', '-', substr($user['comment'], 16, 11)))) : date("Y-m-d"))
        ]);
    }
}
}

class RouterosAPI
{
    var $debug     = false; //  Show debug information
    var $connected = false; //  Connection state
    var $port      = 8728;  //  Port to connect to (default 8729 for ssl)
    var $ssl       = false; //  Connect using SSL (must enable api-ssl in IP/Services)
    var $timeout   = 3;     //  Connection attempt timeout and data read timeout
    var $attempts  = 5;     //  Connection attempt count
    var $delay     = 3;     //  Delay between connection attempts in seconds

    var $socket;            //  Variable for storing socket resource
    var $error_no;          //  Variable for storing connection error number, if any
    var $error_str;         //  Variable for storing connection error text, if any

    /* Check, can be var used in foreach  */
    public function isIterable($var)
    {
        return $var !== null
        && (is_array($var)
            || $var instanceof Traversable
            || $var instanceof Iterator
            || $var instanceof IteratorAggregate
        );
    }

    /**
     * Print text for debug purposes
     *
     * @param string      $text       Text to print
     *
     * @return void
     */
    public function debug($text)
    {
        if ($this->debug) {
            echo $text . "\n";
        }
    }

    /**
     *
     *
     * @param string        $length
     *
     * @return void
     */
    public function encodeLength($length)
    {
        if ($length < 0x80) {
            $length = chr($length);
        } elseif ($length < 0x4000) {
            $length |= 0x8000;
            $length = chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } elseif ($length < 0x200000) {
            $length |= 0xC00000;
            $length = chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } elseif ($length < 0x10000000) {
            $length |= 0xE0000000;
            $length = chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } elseif ($length >= 0x10000000) {
            $length = chr(0xF0) . chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        }

        return $length;
    }


    /**
     * Login to RouterOS
     *
     * @param string      $ip         Hostname (IP or domain) of the RouterOS server
     * @param string      $login      The RouterOS username
     * @param string      $password   The RouterOS password
     *
     * @return boolean                If we are connected or not
     */
    public function connect($ip, $login, $password)
    {
        for ($ATTEMPT = 1; $ATTEMPT <= $this->attempts; $ATTEMPT++) {
            $this->connected = false;
            $PROTOCOL = ($this->ssl ? 'ssl://' : '' );
            $context = stream_context_create(array('ssl' => array('ciphers' => 'ADH:ALL', 'verify_peer' => false, 'verify_peer_name' => false)));
            $this->debug('Connection attempt #' . $ATTEMPT . ' to ' . $PROTOCOL . $ip . ':' . $this->port . '...');
            $this->socket = @stream_socket_client($PROTOCOL . $ip.':'. $this->port, $this->error_no, $this->error_str, $this->timeout, STREAM_CLIENT_CONNECT,$context);
            if ($this->socket) {
                socket_set_timeout($this->socket, $this->timeout);
                $this->write('/login');
                $RESPONSE = $this->read(false);
                if (isset($RESPONSE[0]) && $RESPONSE[0] == '!done') {
                    $MATCHES = array();
                    if (preg_match_all('/[^=]+/i', $RESPONSE[1], $MATCHES)) {
                        if ($MATCHES[0][0] == 'ret' && strlen($MATCHES[0][1]) == 32) {
                            $this->write('/login', false);
                            $this->write('=name=' . $login, false);
                            $this->write('=response=00' . md5(chr(0) . $password . pack('H*', $MATCHES[0][1])));
                            $RESPONSE = $this->read(false);
                            if (isset($RESPONSE[0]) && $RESPONSE[0] == '!done') {
                                $this->connected = true;
                                break;
                            }
                        }
                    }
                }
                fclose($this->socket);
            }
            sleep($this->delay);
        }

        if ($this->connected) {
            $this->debug('Connected...');
        } else {
            $this->debug('Error...');
        }
        return $this->connected;
    }


    /**
     * Disconnect from RouterOS
     *
     * @return void
     */
    public function disconnect()
    {
        // let's make sure this socket is still valid.  it may have been closed by something else
        if( is_resource($this->socket) ) {
            fclose($this->socket);
        }
        $this->connected = false;
        $this->debug('Disconnected...');
    }


    /**
     * Parse response from Router OS
     *
     * @param array       $response   Response data
     *
     * @return array                  Array with parsed data
     */
    public function parseResponse($response)
    {
        if (is_array($response)) {
            $PARSED      = array();
            $CURRENT     = null;
            $singlevalue = null;
            foreach ($response as $x) {
                if (in_array($x, array('!fatal','!re','!trap'))) {
                    if ($x == '!re') {
                        $CURRENT =& $PARSED[];
                    } else {
                        $CURRENT =& $PARSED[$x][];
                    }
                } elseif ($x != '!done') {
                    $MATCHES = array();
                    if (preg_match_all('/[^=]+/i', $x, $MATCHES)) {
                        if ($MATCHES[0][0] == 'ret') {
                            $singlevalue = $MATCHES[0][1];
                        }
                        $CURRENT[$MATCHES[0][0]] = (isset($MATCHES[0][1]) ? $MATCHES[0][1] : '');
                    }
                }
            }

            if (empty($PARSED) && !is_null($singlevalue)) {
                $PARSED = $singlevalue;
            }

            return $PARSED;
        } else {
            return array();
        }
    }


    /**
     * Parse response from Router OS
     *
     * @param array       $response   Response data
     *
     * @return array                  Array with parsed data
     */
    public function parseResponse4Smarty($response)
    {
        if (is_array($response)) {
            $PARSED      = array();
            $CURRENT     = null;
            $singlevalue = null;
            foreach ($response as $x) {
                if (in_array($x, array('!fatal','!re','!trap'))) {
                    if ($x == '!re') {
                        $CURRENT =& $PARSED[];
                    } else {
                        $CURRENT =& $PARSED[$x][];
                    }
                } elseif ($x != '!done') {
                    $MATCHES = array();
                    if (preg_match_all('/[^=]+/i', $x, $MATCHES)) {
                        if ($MATCHES[0][0] == 'ret') {
                            $singlevalue = $MATCHES[0][1];
                        }
                        $CURRENT[$MATCHES[0][0]] = (isset($MATCHES[0][1]) ? $MATCHES[0][1] : '');
                    }
                }
            }
            foreach ($PARSED as $key => $value) {
                $PARSED[$key] = $this->arrayChangeKeyName($value);
            }
            return $PARSED;
            if (empty($PARSED) && !is_null($singlevalue)) {
                $PARSED = $singlevalue;
            }
        } else {
            return array();
        }
    }


    /**
     * Change "-" and "/" from array key to "_"
     *
     * @param array       $array      Input array
     *
     * @return array                  Array with changed key names
     */
    public function arrayChangeKeyName(&$array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $tmp = str_replace("-", "_", $k);
                $tmp = str_replace("/", "_", $tmp);
                if ($tmp) {
                    $array_new[$tmp] = $v;
                } else {
                    $array_new[$k] = $v;
                }
            }
            return $array_new;
        } else {
            return $array;
        }
    }


    /**
     * Read data from Router OS
     *
     * @param boolean     $parse      Parse the data? default: true
     *
     * @return array                  Array with parsed or unparsed data
     */
    public function read($parse = true)
    {
        $RESPONSE     = array();
        $receiveddone = false;
        while (true) {
            // Read the first byte of input which gives us some or all of the length
            // of the remaining reply.
            $BYTE   = ord(fread($this->socket, 1));
            $LENGTH = 0;
            // If the first bit is set then we need to remove the first four bits, shift left 8
            // and then read another byte in.
            // We repeat this for the second and third bits.
            // If the fourth bit is set, we need to remove anything left in the first byte
            // and then read in yet another byte.
            if ($BYTE & 128) {
                if (($BYTE & 192) == 128) {
                    $LENGTH = (($BYTE & 63) << 8) + ord(fread($this->socket, 1));
                } else {
                    if (($BYTE & 224) == 192) {
                        $LENGTH = (($BYTE & 31) << 8) + ord(fread($this->socket, 1));
                        $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                    } else {
                        if (($BYTE & 240) == 224) {
                            $LENGTH = (($BYTE & 15) << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                        } else {
                            $LENGTH = ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                        }
                    }
                }
            } else {
                $LENGTH = $BYTE;
            }

            $_ = "";

            // If we have got more characters to read, read them in.
            if ($LENGTH > 0) {
                $_      = "";
                $retlen = 0;
                while ($retlen < $LENGTH) {
                    $toread = $LENGTH - $retlen;
                    $_ .= fread($this->socket, $toread);
                    $retlen = strlen($_);
                }
                $RESPONSE[] = $_;
                $this->debug('>>> [' . $retlen . '/' . $LENGTH . '] bytes read.');
            }

            // If we get a !done, make a note of it.
            if ($_ == "!done") {
                $receiveddone = true;
            }

            $STATUS = socket_get_status($this->socket);
            if ($LENGTH > 0) {
                $this->debug('>>> [' . $LENGTH . ', ' . $STATUS['unread_bytes'] . ']' . $_);
            }

            if ((!$this->connected && !$STATUS['unread_bytes']) || ($this->connected && !$STATUS['unread_bytes'] && $receiveddone)) {
                break;
            }
        }

        if ($parse) {
            $RESPONSE = $this->parseResponse($RESPONSE);
        }

        return $RESPONSE;
    }


    /**
     * Write (send) data to Router OS
     *
     * @param string      $command    A string with the command to send
     * @param mixed       $param2     If we set an integer, the command will send this data as a "tag"
     *                                If we set it to boolean true, the funcion will send the comand and finish
     *                                If we set it to boolean false, the funcion will send the comand and wait for next command
     *                                Default: true
     *
     * @return boolean                Return false if no command especified
     */
    public function write($command, $param2 = true)
    {
        if ($command) {
            $data = explode("\n", $command);
            foreach ($data as $com) {
                $com = trim($com);
                fwrite($this->socket, $this->encodeLength(strlen($com)) . $com);
                $this->debug('<<< [' . strlen($com) . '] ' . $com);
            }

            if (gettype($param2) == 'integer') {
                fwrite($this->socket, $this->encodeLength(strlen('.tag=' . $param2)) . '.tag=' . $param2 . chr(0));
                $this->debug('<<< [' . strlen('.tag=' . $param2) . '] .tag=' . $param2);
            } elseif (gettype($param2) == 'boolean') {
                fwrite($this->socket, ($param2 ? chr(0) : ''));
            }

            return true;
        } else {
            return false;
        }
    }


    /**
     * Write (send) data to Router OS
     *
     * @param string      $com        A string with the command to send
     * @param array       $arr        An array with arguments or queries
     *
     * @return array                  Array with parsed
     */
    public function comm($com, $arr = array())
    {
        $count = count($arr);
        $this->write($com, !$arr);
        $i = 0;
        if ($this->isIterable($arr)) {
            foreach ($arr as $k => $v) {
                switch ($k[0]) {
                    case "?":
                    $el = "$k=$v";
                    break;
                    case "~":
                    $el = "$k~$v";
                    break;
                    default:
                    $el = "=$k=$v";
                    break;
                }

                $last = ($i++ == $count - 1);
                $this->write($el, $last);
            }
        }

        return $this->read();
    }

    /**
     * Standard destructor
     *
     * @return void
     */
    public function __destruct()
    {
        $this->disconnect();
    }
}

// encrypt decript

function encrypt($string, $key=128) {
    $result = '';
    for($i=0, $k= strlen($string); $i<$k; $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)+ord($keychar));
        $result .= $char;
    }
    return base64_encode($result);
}
function decrypt($string, $key=128) {
    $result = '';
    $string = base64_decode($string);
    for($i=0, $k=strlen($string); $i< $k ; $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result .= $char;
    }
    return $result;
}

// Reformat date time MikroTik
// by Laksamadi Guko

function formatInterval($dtm){
    $val_convert = $dtm;
    $new_format = str_replace("s", "", str_replace("m", "m ", str_replace("h", "h ", str_replace("d", "d ", str_replace("w", "w ", $val_convert)))));
    return $new_format;
}

function formatDTM($dtm){
    if(substr($dtm, 1,1) == "d" || substr($dtm, 2,1) == "d"){
        $day = explode("d",$dtm)[0]."d";
        $day = str_replace("d", "d ", str_replace("w", "w ", $day));
        $dtm = explode("d",$dtm)[1];
    }elseif(substr($dtm, 1,1) == "w" && substr($dtm, 3,1) == "d" || substr($dtm, 2,1) == "w" && substr($dtm, 4,1) == "d"){
        $day = explode("d",$dtm)[0]."d";
        $day = str_replace("d", "d ", str_replace("w", "w ", $day));
        $dtm = explode("d",$dtm)[1];
    }elseif (substr($dtm, 1,1) == "w" || substr($dtm, 2,1) == "w" ) {
        $day = explode("w",$dtm)[0]."w";
        $day = str_replace("d", "d ", str_replace("w", "w ", $day));
        $dtm = explode("w",$dtm)[1];
    }

// secs
    if(strlen($dtm) == "2" && substr($dtm, -1) == "s"){
        $format = $day." 00:00:0".substr($dtm, 0,-1);
    }elseif(strlen($dtm) == "3" && substr($dtm, -1) == "s"){
        $format = $day." 00:00:".substr($dtm, 0,-1);
//minutes
    }elseif(strlen($dtm) == "2" && substr($dtm, -1) == "m"){
        $format = $day." 00:0".substr($dtm, 0,-1).":00";
    }elseif(strlen($dtm) == "3" && substr($dtm, -1) == "m"){
        $format = $day." 00:".substr($dtm, 0,-1).":00";
//hours
    }elseif(strlen($dtm) == "2" && substr($dtm, -1) == "h"){
        $format = $day." 0".substr($dtm, 0,-1).":00:00";
    }elseif(strlen($dtm) == "3" && substr($dtm, -1) == "h"){
        $format = $day." ".substr($dtm, 0,-1).":00:00";

//minutes -secs
    }elseif(strlen($dtm) == "4" && substr($dtm, -1) == "s" && substr($dtm,1,-2) == "m"){
        $format = $day." "."00:0".substr($dtm, 0,1).":0".substr($dtm, 2,-1);
    }elseif(strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm,1,-3) == "m"){
        $format = $day." "."00:0".substr($dtm, 0,1).":".substr($dtm, 2,-1);
    }elseif(strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm,2,-2) == "m"){
        $format = $day." "."00:".substr($dtm, 0,2).":0".substr($dtm, 3,-1);
    }elseif(strlen($dtm) == "6" && substr($dtm, -1) == "s" && substr($dtm,2,-3) == "m"){
        $format = $day." "."00:".substr($dtm, 0,2).":".substr($dtm, 3,-1);

//hours -secs
    }elseif(strlen($dtm) == "4" && substr($dtm, -1) == "s" && substr($dtm,1,-2) == "h"){
        $format = $day." 0".substr($dtm, 0,1).":00:0".substr($dtm, 2,-1);
    }elseif(strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm,1,-3) == "h"){
        $format = $day." 0".substr($dtm, 0,1).":00:".substr($dtm, 2,-1);
    }elseif(strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm,2,-2) == "h"){
        $format = $day." ".substr($dtm, 0,2).":00:0".substr($dtm, 3,-1);
    }elseif(strlen($dtm) == "6" && substr($dtm, -1) == "s" && substr($dtm,2,-3) == "h"){
        $format = $day." ".substr($dtm, 0,2).":00:".substr($dtm, 3,-1);

//hours -secs
    }elseif(strlen($dtm) == "4" && substr($dtm, -1) == "m" && substr($dtm,1,-2) == "h"){
        $format = $day." 0".substr($dtm, 0,1).":0".substr($dtm, 2,-1).":00";
    }elseif(strlen($dtm) == "5" && substr($dtm, -1) == "m" && substr($dtm,1,-3) == "h"){
        $format = $day." 0".substr($dtm, 0,1).":".substr($dtm, 2,-1).":00";
    }elseif(strlen($dtm) == "5" && substr($dtm, -1) == "m" && substr($dtm,2,-2) == "h"){
        $format = $day." ".substr($dtm, 0,2).":0".substr($dtm, 3,-1).":00";
    }elseif(strlen($dtm) == "6" && substr($dtm, -1) == "m" && substr($dtm,2,-3) == "h"){
        $format = $day." ".substr($dtm, 0,2).":".substr($dtm, 3,-1).":00";

//hours minutes secs
    }elseif(strlen($dtm) == "6" && substr($dtm, -1) == "s" && substr($dtm,3,-2) == "m" && substr($dtm,1,-4) == "h"){
        $format = $day." 0".substr($dtm, 0,1).":0".substr($dtm, 2,-3).":0".substr($dtm, 4,-1);
    }elseif(strlen($dtm) == "7" && substr($dtm, -1) == "s" && substr($dtm,3,-3) == "m" && substr($dtm,1,-5) == "h"){
        $format = $day." 0".substr($dtm, 0,1).":0".substr($dtm, 2,-4).":".substr($dtm, 4,-1);
    }elseif(strlen($dtm) == "7" && substr($dtm, -1) == "s" && substr($dtm,4,-2) == "m" && substr($dtm,1,-5) == "h"){
        $format = $day." 0".substr($dtm, 0,1).":".substr($dtm, 2,-3).":0".substr($dtm, 5,-1);
    }elseif(strlen($dtm) == "8" && substr($dtm, -1) == "s" && substr($dtm,4,-3) == "m" && substr($dtm,1,-6) == "h"){
        $format = $day." 0".substr($dtm, 0,1).":".substr($dtm, 2,-4).":".substr($dtm, 5,-1);
    }elseif(strlen($dtm) == "7" && substr($dtm, -1) == "s" && substr($dtm,4,-2) == "m" && substr($dtm,2,-4) == "h"){
        $format = $day." ".substr($dtm, 0,2).":0".substr($dtm, 3,-3).":0".substr($dtm, 5,-1);
    }elseif(strlen($dtm) == "8" && substr($dtm, -1) == "s" && substr($dtm,4,-3) == "m" && substr($dtm,2,-5) == "h"){
        $format = $day." ".substr($dtm, 0,2).":0".substr($dtm, 3,-4).":".substr($dtm, 5,-1);
    }elseif(strlen($dtm) == "8" && substr($dtm, -1) == "s" && substr($dtm,5,-2) == "m" && substr($dtm,2,-5) == "h"){
        $format = $day." ".substr($dtm, 0,2).":".substr($dtm, 3,-3).":0".substr($dtm, 6,-1);
    }elseif(strlen($dtm) == "9" && substr($dtm, -1) == "s" && substr($dtm,5,-3) == "m" && substr($dtm,2,-6) == "h"){
        $format = $day." ".substr($dtm, 0,2).":".substr($dtm, 3,-4).":".substr($dtm, 6,-1);

    }else{
        $format = $dtm;
    }
    return $format;
}


function randN($length) {
    $chars = "23456789";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for($i=1;$i<=$length;$i++)
    {
        $randChar = rand(0,$charCount-1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randUC($length) {
    $chars = "ABCDEFGHIJKMNPRSTUVWXYZ";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for($i=1;$i<=$length;$i++)
    {
        $randChar = rand(0,$charCount-1);
        $result .= $charArray[$randChar];
    }
    return $result;
}
function randLC($length) {
    $chars = "abcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for($i=1;$i<=$length;$i++)
    {
        $randChar = rand(0,$charCount-1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randULC($length) {
    $chars = "ABCDEFGHIJKMNPRSTUVWXYZabcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for($i=1;$i<=$length;$i++)
    {
        $randChar = rand(0,$charCount-1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randNLC($length) {
    $chars = "23456789abcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for($i=1;$i<=$length;$i++)
    {
        $randChar = rand(0,$charCount-1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randNUC($length) {
    $chars = "23456789ABCDEFGHIJKMNPRSTUVWXYZ";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for($i=1;$i<=$length;$i++)
    {
        $randChar = rand(0,$charCount-1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randNULC($length) {
    $chars = "23456789ABCDEFGHIJKMNPRSTUVWXYZabcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for($i=1;$i<=$length;$i++)
    {
        $randChar = rand(0,$charCount-1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

?>

