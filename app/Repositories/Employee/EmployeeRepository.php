<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Models\EmployeeTraining;
use App\Models\EducationalBackground;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Training\TrainingRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{

    /**
     * EmployeeRepository constructor.
     *
     * @param Employee $model
     */

    protected $trainingRepository;

    public function __construct(Employee $model, TrainingRepositoryInterface $trainingRepository)
    {
        parent::__construct($model);
        $this->trainingRepository = $trainingRepository;
    }

    public function store(array $attributes)
    {
        DB::beginTransaction();
        try {
            //
            $employee = $this->create($attributes);

            // EDUCATIONAL BACKGROUNDS
            if(isset($attributes['educational_backgrounds'])) {
                $this->educationalBackgrounds($attributes['educational_backgrounds'], $employee->id);
            }

            // TRAININGS
            if(isset($attributes['trainings'])){
                $trainings = $attributes['trainings'];
                foreach($trainings as $training) {
                    $training_result = $this->trainingRepository->create($training);
                    // Attach the training to the employee
                    EmployeeTraining::create([
                        'employee_id' => $employee->id,
                        'training_id' => $training_result->id,
                    ]);
                }
            }

            DB::commit();

            return $employee;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }

    }

    public function educationalBackgrounds(array $attributes, $employee_id, $is_update = false)
    {
        if($is_update === false) {
            foreach($attributes as $attribute) {
                $attribute['employee_id'] = $employee_id;
                EducationalBackground::create($attribute);
            }
        } else {
            foreach($attributes as $attribute) {
                foreach ($attributes as $attribute) {
                    $educationalBackground = EducationalBackground::find($attribute['id']);
                
                    if ($educationalBackground) {
                        $educationalBackground->update($attribute);
                    }
                }
            }
        }
    }
}
