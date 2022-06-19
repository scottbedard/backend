<?php

namespace Bedard\Backend\Classes;

class Alert
{
    public static function trigger(string $message, string $type = 'info')
    {
        session()->flash('alert', [
            'message' => $message,
            'type' => $type,
        ]);
    }

    public static function danger(string $message)
    {
        self::trigger($message, 'danger');
    }

    public static function info(string $message)
    {
        self::trigger($message, 'default');
    }
    
    public static function success(string $message)
    {
        self::trigger($message, 'success');
    }
}
