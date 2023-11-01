<?php

return [

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
    ]

];