<?php

namespace Engine\Monitoring;

use Engine\Config;
use Engine\Http\Request;
use Engine\Http\Response;
use Engine\Routes\Route;

/**
 * That Class will save some message on log file, separated by years/months/days
 * On the message will be include also Ip address of the user and the time of writing on the message.
 * @package Engine\Monitoring
 */
class Log
{
    /**
     * Write log message on the log file
     * @param string $msg Message for the log
     */
    public final static function write($msg)
    {
        $ip = Request::getInstance()->ip();
        $url = Route::getUrl();
        $message = date('Y-m-d h:i:s') . '; IP: ' . $ip . ";\n" . 'URL: ' . $url . ";\n" . $msg . "\n\n";

        $dir = Config::getInstance()->get('app', 'logs_dir');

        // Get the year folder
        $year = $dir . date('Y');
        if (!is_dir($year)) {
            mkdir($year);
        }

        // Get the month folder
        $month = $year . '/' . date('m');
        if (!is_dir($month)) {
            mkdir($month);
        }

        $file = $month . '/' . date('d') . '.log';
        error_log($message, 3, $file);
    }
}
