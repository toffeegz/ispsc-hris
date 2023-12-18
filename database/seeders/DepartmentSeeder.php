<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::truncate();

        $departments = [
            [
                'name' => 'College of Teacher Education',
                'acronym' => 'CTE',
                'non_teaching' => false,
                'color' => '#e24b26',
                'description' => 'The College of Teacher Education is dedicated to preparing the next generation of educators. Our programs focus on equipping future teachers with the knowledge and skills necessary to excel in the field of education. We are committed to fostering a culture of learning, innovation, and leadership in education.'
            ],
            [
                'name' => 'College of Arts and Sciences',
                'acronym' => 'CAS',
                'non_teaching' => false,
                'color' => '#3b8ad9',
                'description' => 'The College of Arts and Sciences is a vibrant intellectual hub where creativity and critical thinking thrive. Our diverse range of programs spans the humanities, social sciences, and natural sciences, allowing students to explore their passions and interests. We encourage interdisciplinary exploration and offer a rich educational experience that prepares students for a wide array of careers.'
            ],
            [
                'name' => 'College of Business Education',
                'acronym' => 'CBE',
                'non_teaching' => false,
                'color' => '#ffdb69',
                'description' => 'The College of Business Education is dedicated to shaping future business leaders and entrepreneurs. We provide a comprehensive business education that combines theoretical knowledge with practical skills. Our programs focus on leadership, innovation, and ethical business practices to prepare students for success in the ever-evolving world of business.'
            ],
            [
                'name' => 'Criminal Justice Education',
                'acronym' => 'CJE',
                'non_teaching' => false,
                'color' => '#f18227',
                'description' => 'The Criminal Justice Education is committed to providing students with the knowledge and skills needed for careers in the field of criminal justice. Our programs cover a wide range of topics, from law enforcement and criminology to legal studies. We prioritize hands-on learning and critical thinking, ensuring that our graduates are well-prepared for the challenges of the criminal justice profession.'
            ],
            [
                'name' => 'Academic',
                'acronym' => 'ACAD',
                'non_teaching' => true,
                'color' => '#7bc0f7',
                'description' => 'The Academic Department is responsible for managing various administrative tasks, support services, and non-academic functions of the educational institution. It oversees human resources, finance, facilities management, information technology, student services, admissions, public relations, and other essential administrative functions to ensure the smooth operation of the institution.'
            ],
        ];
        
        foreach ($departments as $departmentData) {
            Department::create($departmentData);
        }
    }
}
