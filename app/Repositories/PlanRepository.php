<?php

namespace App\Repositories;

use App\Models\Plan;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PlanRepository
 * @package App\Repositories
 * @version January 29, 2019, 5:44 am UTC
 *
 * @method Plan findWithoutFail($id, $columns = ['*'])
 * @method Plan find($id, $columns = ['*'])
 * @method Plan first($columns = ['*'])
*/
class PlanRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'hotspot_id',
        'name',
        'price',
        'shared_users'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Plan::class;
    }
}
