<?php

return [
    'enterprise' => [
        'user_type' => 'enterprise',
        'is_active' => [
            'inactive' => 0,
            'active' => 1,
        ],
        'role' => [
            'admin' => [
                'id' => 1,
                'name' => 'Admin',
            ],
            'user' =>  [
                'id' => 2,
                'name' => 'User',
            ],
        ],
        'status' => [
            'pending_approve' => 0,
            'approved' => 1,
            'rejected' => 2,
        ],
        'major' => [
            'type' => [
                'full_time',
                'part_time',
                'remote',
            ],
        ],
    ],
];
