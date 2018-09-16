<?php

namespace App\Config;

class Config
{
    const
        PARAM_PROD = 'production',
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
    private static $params = [
        self::PARAM_PROD => true,
        self::VENDOR_DOCTRINE => [
            self::FIELD_DRIVER => 'pdo_mysql',
            self::FIELD_HOST => 'localhost',
            self::FIELD_USER     => 'root',
            self::FIELD_PASS => '',
            self::FIELD_HOST   => 'kznew',
            self::FIELD_CHARSET  => 'UTF8'
        ]
    ];

    /**
     * @return array
     */
    public static function getDoctrine()
    {
        return self::$params[self::VENDOR_DOCTRINE];
    }

    /**
     * @return bool
     */
    public static function isProd()
    {
        return self::$params[self::PARAM_PROD];
    }

}