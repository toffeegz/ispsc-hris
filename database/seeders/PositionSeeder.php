<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Department;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            "CTE" =>  [
                [
                    "name" =>  "Educational Specialist II",
                    "description" =>  "Responsible for curriculum development and educational planning."
                ],
                [
                    "name" =>  "School Counselor II",
                    "description" =>  "Provides guidance and counseling services to students."
                ],
                [
                    "name" =>  "Language Instructor II",
                    "description" =>  "Teaches language and communication skills to students."
                ]
            ],
            "CAS" =>  [
                [
                    "name" =>  "Research Analyst II",
                    "description" =>  "Conducts research and data analysis in various fields."
                ],
                [
                    "name" =>  "Lab Technician II",
                    "description" =>  "Supports laboratory operations and experiments."
                ],
                [
                    "name" =>  "Librarian II",
                    "description" =>  "Manages library resources and assists students with research."
                ]
            ],
            "CBE" =>  [
                [
                    "name" =>  "Finance Manager II",
                    "description" =>  "Manages financial operations and budgeting for the college."
                ],
                [
                    "name" =>  "Marketing Coordinator II",
                    "description" =>  "Coordinates marketing and promotional activities for the college."
                ],
                [
                    "name" =>  "Entrepreneurship Advisor II",
                    "description" =>  "Provides guidance to aspiring entrepreneurs and business students."
                ]
            ],
            "CJE" =>  [
                [
                    "name" =>  "Criminal Investigator II",
                    "description" =>  "Conducts criminal investigations and gathers evidence."
                ],
                [
                    "name" =>  "Forensic Analyst II",
                    "description" =>  "Analyzes forensic evidence for criminal cases."
                ],
                [
                    "name" =>  "Legal Counselor II",
                    "description" =>  "Offers legal guidance and support to students interested in law."
                ]
            ],
            "ACAD" =>  [
                [
                    'name' => 'Admin Aide III (driver II)',
                    'description' => 'Responsible for providing driving services and assisting in administrative tasks.',
                ],
                [
                    'name' => 'Armorer II',
                    'description' => 'Responsible for maintaining and managing firearms and related equipment.',
                ],
                [
                    'name' => 'Admin Office I',
                    'description' => 'Responsible for basic clerical tasks within the administrative department.',
                ],
                [
                    'name' => 'Security Guard I',
                    'description' => 'Responsible for ensuring security and safety in the institution.',
                ],
                [
                    'name' => 'Budget Officer III',
                    'description' => 'Responsible for financial planning and budget management.',
                ],
                [
                    'name' => 'Registrar II',
                    'description' => 'Responsible for managing student records and registration processes.',
                ],
                [
                    'name' => 'Admin Assistant III',
                    'description' => 'Provides administrative support and assistance.',
                ],
                [
                    'name' => 'Admin Officer III (Cashier II)',
                    'description' => 'Responsible for cash management and financial transactions.',
                ],
                [
                    'name' => 'Human Resource Management Officer III',
                    'description' => 'Manages human resources and personnel matters.',
                ],
                [
                    'name' => 'Admin Officer III (Supply Officer II)',
                    'description' => 'Responsible for managing supplies and inventory.',
                ],
                [
                    'name' => 'Admin Aide III (utility worker III)',
                    'description' => 'Performs general utility and maintenance tasks.',
                ],
                [
                    'name' => 'Dentist I',
                    'description' => 'Provides dental care services to the institution.',
                ],
                [
                    'name' => 'College Librarian II',
                    'description' => 'Manages library resources and services.',
                ],
                [
                    'name' => 'Accountant III',
                    'description' => 'Manages financial records and accounting tasks.',
                ],
                [
                    'name' => 'Planning Officer III',
                    'description' => 'Responsible for strategic planning and development.',
                ],
                [
                    'name' => 'Nurse II',
                    'description' => 'Provides healthcare and nursing services.',
                ],
                [
                    'name' => 'Admin Aide III (laborer II)',
                    'description' => 'Performs labor and maintenance tasks.',
                ],
            ]
        ];
        
        foreach($departments as $key => $positions) {
            $department = Department::where('acronym', $key)->first();
            foreach ($positions as $position) {
                $position['department_id'] = $department->id;
                Position::create($position);
            }
        }
    }
}
