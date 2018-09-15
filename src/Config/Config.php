<?php
/**
 * Created by PhpStorm.
 * User: Den
 * Date: 15.09.2018
 * Time: 16:23
 */

namespace App\Config;


class Config
{
    const
        VENDOR_DOCTRINE = 'doctrine',
        VENDOR_SILEX = 'silex'
    ;

    const
        FIELD_DRIVER = 'driver',
        FIELD_HOST = 'host',
        FIELD_USER = 'user',
        FIELD_PASS = 'password',
        FIELD_DBNAME = 'dbname',
        FIELD_CHARSET = 'charset';

    /**
     * @var array
     */
    public static $params = [
        self::VENDOR_DOCTRINE => [
            self::FIELD_DRIVER => 'pdo_mysql',
            self::FIELD_HOST => 'localhost',
            self::FIELD_USER     => 'root',
            self::FIELD_PASS => '',
            self::FIELD_HOST   => 'kznew',
            self::FIELD_CHARSET  => 'UTF8'
        ]
    ];


}