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
            'name' => 'Strategic Functions',
            'weight' => 40 / 100,
        ],
        [
            'name' => 'Core Functions',
            'weight' => 40 / 100,
        ],
        [
            'name' => 'Support Functions',
            'weight' => 20 / 100,
        ]
    ]

];