<?php

namespace App\Repositories\Award;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

use App\Repositories\Base\BaseRepository;
use App\Models\Award;
use App\Models\AwardOverview;

class AwardRepository extends BaseRepository implements AwardRepositoryInterface
{

    /**
     * AwardRepository constructor.
     *
     * @param Award $model
     */

    public function __construct(Award $model)
    {
        parent::__construct($model);
    }

    public function overview(array $search = [], string $sortByColumn = 'last_date_awarded', string $sortBy = 'DESC')
    {
        return AwardOverview::filter($search)->orderBy($sortByColumn, $sortBy)->paginate(request('limit') ?? 10);
    }

}
