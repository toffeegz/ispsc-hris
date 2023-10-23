<?php

namespace App\Repositories\IpcrItem;

use App\Models\IpcrItem;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class IpcrItemRepository extends BaseRepository implements IpcrItemRepositoryInterface
{

    /**
     * IpcrItemRepository constructor.
     *
     * @param IpcrItem $model
     */

    public function __construct(IpcrItem $model)
    {
        parent::__construct($model);
    }
}
