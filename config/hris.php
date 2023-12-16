<?php

return [

    'frontend_url' => env('FRONTEND_URL', 'http://localhost:3000/'),

    'schedules' => [
        'default' => [
            'in' => '08:00:00',
            'out' => '17:00:00',
            'is_default' => true
        ],
        'flexible' => [
            'in' => '07:30:00',
            'out' => '16:30:00',
            'is_default' => false
        ]
    ],

    'ipcr_categories' => [
        [
            'order' => 1,
            'name' => 'Strategic Functions',
            'weight' => 40 / 100,
        ],
        [
            'order' => 2,
            'name' => 'Core Functions',
            'weight' => 40 / 100,
        ],
        [
            'order' => 3,
            'name' => 'Support Functions',
            'weight' => 20 / 100,
        ]
    ],

    'ipcr_subcategories' => [
        '2' => [ // ipcr category 2 core functions
            [
                'name' => 'Instruction',
                'weight' => 67.0,
                'children' => [
                    ['name' => 'Instructional Materials Development', 'weight' => 33.3333],
                    ['name' => 'Management of Learning and Classroom Organization for Instruction', 'weight' => 33.3333],
                    ['name' => 'Assessment/ Evaluation of Students\' Performance', 'weight' => 33.3333],
                ],
            ],
            [
                'name' => 'Research, Extension, Production',
                'weight' => 33,
                'children' => [
                    ['name' => 'Research Services', 'weight' => 16.5],
                    ['name' => 'Extension Services', 'weight' => 16.5],
                    ['name' => 'Production Services', 'weight' => 67],
                ],
            ],
            ['name' => 'Administrative Function (Designation)'],
        ],
        '3' => [ // ipcr category 3 support functions
            [
                'name' => 'Prompt Submission of Documents',
                'weight' => 10.0,
            ],
            [
                'name' => 'Attendance to:',
                'weight' => 10.0,
            ],
        ],
    ],

    'ipcr_support_functions' => [
        'a' => [
            'DTR',
            'ITR',
            'PDS',
            'SALN',
            'Medical records'
        ],
        'b' => [
            'College Initiated Activities',
            'Civil Service Initiated Activities',
            'National/Local /Provincial initiated Activities',
            'Participation to community activities.',
            'Attendance of Trainings/Conference/ Seminars',
            'Attendance to Meetings (Faculty, Academic Council, Administrative Council, and RDE Council',
        ]
    ]
    

];