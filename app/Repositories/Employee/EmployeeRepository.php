<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Models\EmployeeTraining;
use App\Models\EducationalBackground;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Training\TrainingRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
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
            if($attributes['is_flexible'] === 1) {
                $schedule = Schedule::where('is_default',false)->first();
                $attributes['schedule_id'] = $schedule->id;
            }
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

    public function edit(array $attributes, $id)
    {
        DB::beginTransaction();
        try {
            if($attributes['is_flexible'] === 1) {
                $schedule = Schedule::where('is_default',false)->first();
                $attributes['schedule_id'] = $schedule->id;
            }
            // return $attributes;
            $employee = $this->update($attributes, $id);
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
