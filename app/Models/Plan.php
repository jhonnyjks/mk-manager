<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Plan
 * @package App\Models
 * @version January 29, 2019, 5:44 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection User
 * @property string hotspot_id
 * @property string name
 * @property decimal price
 * @property integer shared_users
 */
class Plan extends Model
{

    public $table = 'plans';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'hotspot_id',
        'name',
        'price',
        'shared_users'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'hotspot_id' => 'string',
        'name' => 'string',
        'shared_users' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
