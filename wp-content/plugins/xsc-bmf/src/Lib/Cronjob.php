<?php

namespace XSC\BMF\Lib;

use XSC\BMF\Services\CronjobIntervals;

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

abstract class Cronjob
{
    abstract protected static function get_interval();
    abstract public static function run();

    public static function init()
    {
        add_action('init', [get_called_class(), 'schedule_cron']);
        add_action(static::get_action_name(), [get_called_class(), 'action_callback']);
    }

    public static function schedule_cron()
    {
        if(!wp_next_scheduled(static::get_action_name()))
        {
            wp_schedule_event(time(), static::get_interval(), static::get_action_name());
        }
    }

    public static function get_action_name()
    {
        $classname = strtolower(get_called_class());
        $cleaned = str_replace('\\', '_', $classname);
        return $cleaned . '_cronjob';
    }

    public static function get_doing_cron_option_name()
    {
        return 'doing_'.static::get_action_name();
    }

    public static function action_callback()
    {
        // Are we already doing the cronjob, if so, abort early.
        if(get_option(static::get_doing_cron_option_name(), false) === true)
        {
            return;
        }

        // Leave an option in the db for the next cron to read that we're busy.
        update_option(static::get_doing_cron_option_name(), true);

        try {
            static::run();
        } catch (\Throwable $th) {
            throw $th;
        } finally {
            // Allow the next cron to actually run again.
            update_option(static::get_doing_cron_option_name(), false);
        }
    }
}
