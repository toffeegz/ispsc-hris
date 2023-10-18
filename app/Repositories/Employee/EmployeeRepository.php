<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Models\EmployeeTraining;
use App\Models\Training;
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
                $educational_backgrounds = $attributes['educational_backgrounds'];
                foreach($educational_backgrounds as $educational_background) {
                    $educational_background['employee_id'] = $employee->id;
                    EducationalBackground::create($educational_background);
                }
            }

            // TRAININGS
            if(isset($attributes['trainings'])){
                $trainings = $attributes['trainings'];
                foreach($trainings as $training) {
                    $training_result = $this->trainingRepository->create($training);
                    // Attach the training to the employee
                    EmployeeTraining::insert([
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

    public function education(array $attributes, $id)
    {
        DB::beginTransaction();
        try {
            foreach($attributes as $attribute) {
                $attribute["employee_id"] = $id;
                if (isset($attribute["id"])) {
                    EducationalBackground::findOrFail($attribute['id'])->update($attribute);
                } elseif (isset($attribute["level"])) {
                    EducationalBackground::create($attribute);
                }
            }
            DB::commit();
            return "Educational Background Updated Successfully!";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function training(array $attributes, $id) 
    {
        DB::beginTransaction();
        try {
            $employee = Employee::find($id);
            // Create or update training records
            foreach ($attributes as $attribute) {
                $training = Training::firstOrNew([
                    'title' => $attribute['title'],
                    'description' => $attribute['description'],
                    'conducted_by' => $attribute['conducted_by'],
                    // Add other fields here
                ]);

                $training->save();

                // Check if the training is already associated with the employee
                if (!$employee->trainings->contains($training->id)) {
                    // Use syncWithoutDetaching to attach the training record
                    $employee->trainings()->syncWithoutDetaching([$training->id]);
                }
            }

            // Detach training records that are not in the provided list
            $employee->trainings()->whereNotIn('id', collect($attributes)->pluck('id'))->detach();

            DB::commit();
            return "Trainings & Seminars Updated Successfully!";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
