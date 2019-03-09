<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

/**
 * Class User
 * @package App\Models
 * @version January 29, 2019, 5:45 am UTC
 *
 * @property \App\Models\Plan plan
 * @property \App\Models\UserType userType
 * @property string name
 * @property string email
 * @property string username
 * @property string password
 * @property string|\Carbon\Carbon email_verified_at
 * @property bigInteger phone
 * @property bigInteger celphone
 * @property bigInteger cpf_cnpj
 * @property integer user_type_id
 * @property integer plan_id
 * @property date last_payment
 * @property string remember_token
 * @property string id_hotspot
 */
class User extends Model
{
    use SoftDeletes;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'username',
        'password',
        // 'email_verified_at',
        'phone',
        'celphone',
        'cpf_cnpj',
        'user_type_id',
        'plan_id',
        'last_payment',
        // 'remember_token',
        'id_hotspot',
        'general_status_id',
        'last_enabled_at',
        'user_id',
        'payment_promise'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'username' => 'string',
        'password' => 'string',
        'user_type_id' => 'integer',
        'plan_id' => 'integer',
        'last_payment' => 'date',
        'remember_token' => 'string',
        'id_hotspot' => 'string',
        'general_status_id' => 'integer',
        'payment_promise' => 'integer',
        'user_id' => 'integer',
        'last_enabled_at' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|min:5|max:90',
        'email' => 'email|max:255',
        'username' => 'required|between:4,20|unique:users,username',
        //'password' => 'required|alpha_num|min:4|max:20',
        'celphone' => 'required|numeric|between:900000000,99900000000',
        'user_type_id' => 'numeric|exists:user_types,id',
        'general_status_id' => 'numeric|exists:general_statuses,id',
        'plan_id' => 'numeric|exists:plans,id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function userType()
    {
        return $this->belongsTo(\App\Models\UserType::class);
    }
}
