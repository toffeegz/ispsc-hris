<?php

namespace App\Repositories\EducationalBackground;

use App\Models\EducationalBackground;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class EducationalBackgroundRepository extends BaseRepository implements EducationalBackgroundRepositoryInterface
{

    /**
     * EducationalBackgroundRepository constructor.
     *
     * @param EducationalBackground $model
     */

    public function __construct(EducationalBackground $model)
    {
        parent::__construct($model);
    }
}
