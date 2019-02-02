<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class GeneralStatus
 * @package App\Models
 * @version February 2, 2019, 3:08 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection User
 * @property string name
 * @property string description
 */
class GeneralStatus extends Model
{
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string'
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
