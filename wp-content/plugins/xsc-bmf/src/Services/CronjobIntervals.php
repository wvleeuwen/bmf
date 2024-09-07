<?php

namespace XSC\BMF\Services;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

class CronjobIntervals
{
    const CRONJOB_EVERY_MINUTE = 'bmf_every_minute';

    public static function init()
    {
        add_filter('cron_schedules', [__CLASS__, 'add_cron_interval']);
    }

    public static function add_cron_interval($schedules)
    { 
        $schedules[self::CRONJOB_EVERY_MINUTE] = [
            'interval' => 60,
            'display'  => esc_html__('Every minute', XSC_BMF_TEXTDOMAIN),
        ];

        return $schedules;
    }
}
