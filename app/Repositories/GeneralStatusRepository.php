<?php

namespace App\Repositories;

use App\Models\GeneralStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GeneralStatusRepository
 * @package App\Repositories
 * @version February 2, 2019, 3:08 am UTC
 *
 * @method GeneralStatus findWithoutFail($id, $columns = ['*'])
 * @method GeneralStatus find($id, $columns = ['*'])
 * @method GeneralStatus first($columns = ['*'])
*/
class GeneralStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return GeneralStatus::class;
    }
}
