<?php

namespace App\Commons\Constants;

class NotificationType
{
    const TYPE_SYSTEM = [
        'apply' => 'Công việc',
        'join' => 'Hội thảo',
        'auth' => 'Đăng ký',
    ];

    const TYPE_ENTERPRISE = [
        'apply' => 'Công việc',
        'cooperate' => 'Hợp tác',
        'system' => 'Hệ thống',
        'feedback' => 'Phản hồi',
    ];

    const TYPE_UNIVERSITY = [
        'join' => 'Hội thảo',
        'cooperate' => 'Hợp tác',
        'system' => 'Hệ thống',
        'feedback' => 'Phản hồi',
    ];
}
