<?php

namespace App\Constants;

class OrderConstants
{
    const APPROVE_MIN = 1000;

    const STATUS_WAITING = 1;
    const STATUS_APPROVED = 2;

    public static function getStatusLabels()
    {
        return [
            self::STATUS_WAITING => __('Waiting'),
            self::STATUS_APPROVED => __('Approved')
        ];
    }

    public static function getStatusColors()
    {
        return [
            self::STATUS_WAITING => 'warning',
            self::STATUS_APPROVED => 'success'
        ];
    }
}
