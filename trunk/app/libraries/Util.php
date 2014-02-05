<?php
/**
 * Created by PhpStorm.
 * User: keshav
 * Date: 03/02/14
 * Time: 00:04
 */

namespace libraries;


class Util {

    public static function currentDate()
    {
        return gmdate('Y-m-d H:i:s');
    }

    public static function lastOneDayFromNow()
    {
        return gmdate('Y-m-d H:i:s', strtotime('-1 days'));
    }

} 