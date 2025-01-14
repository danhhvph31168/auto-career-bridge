<?php

return [
    'sidebar' => [
        //super-admin
        [
            'title' => 'Thống kê',
            'icon' => 'ri-dashboard-2-line',
            'name' => [],
            'roles' => ['super-admin'],
            'route' => 'system-admin.dashboard',
        ],
        [
            'title' => 'Quản lý tài khoản',
            'icon' => 'ri-pencil-ruler-2-line',
            'name' => ['dashboard'],
            'roles' => ['super-admin'],
            'subModule' => [
                [
                    'title' => 'Tài khoản doanh nghiệp',
                    'route' => 'system-admin.enterprise.index',
                ],
                [
                    'title' => 'Tài khoản trường học',
                    'route' => 'system-admin.university.users',

                ],
            ],
        ],
        [
            'title' => 'Quản lý sub-admin',
            'icon' => 'ri-window-2-line',
            'name' => ['dashboard'],
            'roles' => ['super-admin'],
            'subModule' => [
                [
                    'title' => 'Danh sách sub-admin',
                    'route' => 'system-admin.sub-admin.index',

                ],
                [
                    'title' => 'Thêm mới sub-admin',
                    'route' => 'system-admin.sub-admin.create',

                ],
            ]
        ],
        [
            'title' => 'Quản lý công việc',
            'icon' => 'ri-file-edit-line',
            'name' => ['dashboard'],
            'roles' => ['super-admin'],
            'route' => 'system-admin.job.index',
        ],
        [
            'title' => 'Quản lý hội thảo',
            'icon' => 'ri-calendar-line',
            'name' => ['dashboard'],
            'roles' => ['super-admin'],
            'route' => 'system-admin.workshop.list',
        ],
        [
            'title' => 'Quản lý chuyên ngành',
            'icon' => 'ri-calendar-line',
            'name' => ['dashboard'],
            'roles' => ['super-admin'],
            'route' => 'system-admin.major.list',
        ],
        [
            'title' => 'Quản lý thông báo',
            'icon' => 'ri-book-3-line',
            'name' => ['dashboard'],
            'roles' => ['super-admin'],
            'route' => 'admin.notifications.index',
        ],
        //enterprise
        [
            'title' => 'Thống kê',
            'icon' => 'ri-dashboard-2-line',
            'name' => ['profile'],
            'roles' => ['enterprise'],
            'route' => 'enterprise.dashboard',
        ],
        [
            'title' => 'Quản lý nhân viên',
            'icon' => 'ri-account-circle-line',
            'name' => ['staff'],
            'roles' => ['enterprise'],
            'subModule' => [
                [
                    'title' => 'Danh sách nhân viên',
                    'route' => 'enterprise.users.index',
                ],
                [
                    'title' => 'Thêm mới nhân viên',
                    'route' => 'enterprise.users.create',
                ],
            ],
        ],
        [
            'title' => 'Quản lý công việc',
            'icon' => 'ri-file-edit-line',
            'name' => ['dashboard'],
            'roles' => ['enterprise'],
            'subModule' => [
                [
                    'title' => 'Danh sách công việc',
                    'route' => 'enterprise.jobs.index',
                ],
                [
                    'title' => 'Thêm mới công việc',
                    'route' => 'enterprise.jobs.create',
                ],
            ],
        ],
        [
            'title' => 'Quản lý thông báo',
            'icon' => 'ri-book-3-line',
            'name' => ['dashboard'],
            'roles' => ['enterprise'],
            'route' => 'admin.notifications.index',
        ],
        [
            'title' => 'Quản lý hợp tác',
            'icon' => 'ri-mail-line',
            'name' => ['dashboard'],
            'roles' => ['enterprise'],
            'route' => 'enterprise.collaborations.index',
        ],
        //university
        [
            'title' => 'Thống kê',
            'icon' => 'ri-dashboard-2-line',
            'name' => ['profile'],
            'roles' => ['university'],
            'route' => 'university.dashboard',
        ],
        [
            'title' => 'Quản lý ngành học',
            'icon' => 'ri-bookmark-line',
            'name' => ['major'],
            'roles' => ['university'],
            'route' => 'university.major.index',
        ],
        [
            'title' => 'Quản lý giáo vụ',
            'icon' => 'ri-user-settings-line',
            'name' => ['user'],
            'roles' => ['university'],
            'subModule' => [
                [
                    'title' => 'Danh sách giáo vụ',
                    'route' => 'university.index',
                ],
                [
                    'title' => 'Thêm mới giáo vụ',
                    'route' => 'university.create',
                ],
            ],
        ],
        [
            'title' => 'Quản lý hội thảo',
            'icon' => 'ri-calendar-line',
            'name' => ['dashboard'],
            'roles' => ['university'],
            'subModule' => [
                [
                    'title' => 'Danh sách hội thảo',
                    'route' => 'university.workshop.index',
                ],
                [
                    'title' => 'Thêm mới hội thảo',
                    'route' => 'university.workshop.create',
                ],
            ],
        ],
        [
            'title' => 'Quản lý hợp tác',
            'icon' => 'ri-mail-line',
            'name' => ['dashboard'],
            'roles' => ['university'],
            'route' => 'university.collaborations.index',
        ],
        //other
        [
            'title' => 'Quản lý thông báo',
            'icon' => 'ri-book-3-line',
            'name' => ['dashboard'],
            'roles' => ['university'],
            'route' => 'admin.notifications.index',
        ],
    ],
];
