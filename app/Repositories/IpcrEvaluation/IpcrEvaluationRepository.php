<?php

namespace App\Repositories\IpcrEvaluation;

use App\Models\IpcrEvaluation;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class IpcrEvaluationRepository extends BaseRepository implements IpcrEvaluationRepositoryInterface
{

    /**
     * IpcrEvaluationRepository constructor.
     *
     * @param IpcrEvaluation $model
     */

    public function __construct(IpcrEvaluation $model)
    {
        parent::__construct($model);
    }

    public function index(array $search = [], $payload, array $relations = [], string $sortByColumn = 'created_at', string $sortBy = 'DESC')
    {
        $query = $this->model;
        if($relations) {
            $query = $query->with($relations);
        }

        // Filter by adjectival_rating if it exists in the payload
        if (isset($payload['adjectival_rating'])) {
            if($payload['adjectival_rating'] != 'all') {
                $adjectivalRating = intval($payload['adjectival_rating']);
                $query = $query->where(function ($query) use ($adjectivalRating) {
                    switch ($adjectivalRating) {
                        case 5:
                            $query->where('final_average_rating', '>=', 5);
                            break;
                        case 4:
                            $query->whereBetween('final_average_rating', [4, 4.99]);
                            break;
                        case 3:
                            $query->whereBetween('final_average_rating', [3, 3.99]);
                            break;
                        case 2:
                            $query->whereBetween('final_average_rating', [2, 2.99]);
                            break;
                        case 1:
                            $query->whereBetween('final_average_rating', [1, 1.99]);
                            break;
                        default:
                            // Handle invalid input if necessary
                            break;
                    }
                });
            }
            
        }

        // Filter by period_id if it exists in the payload
        if (isset($payload['period_id'])) {
            $query = $query->where('ipcr_period_id', $payload['period_id']);
        }

        // Filter by department_id if it exists in the payload
        if (isset($payload['department_ids'])) {
            // Convert department_ids to an array if it's a string separated by commas
            if (isset($payload['department_ids'])) {
                if (is_string($payload['department_ids'])) {
                    $payload['department_ids'] = explode(',', $payload['department_ids']);
                }
            }

            $query = $query->whereIn('employee_id', function ($subQuery) use ($payload) {
                $subQuery->select('id')
                    ->from('employees')
                    ->whereIn('department_id', $payload['department_ids']);
            });
        }

        return $query->filter($search)->orderBy($sortByColumn, $sortBy)->paginate(request('limit') ?? 10);
    }
    
}
