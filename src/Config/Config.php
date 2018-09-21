<?php

namespace App\Config;

class Config
{
    const
        PARAM_PROD = 'production',
        VENDOR_DOCTRINE = 'doctrine',
        VENDOR_TWIG = 'twig';

    const
        FIELD_DRIVER = 'driver',
        FIELD_HOST = 'host',
        FIELD_USER = 'user',
        FIELD_PASS = 'password',
        FIELD_DBNAME = 'dbname',
        FIELD_CHARSET = 'charset',
        FIELD_PATH = 'path',
        FIELD_CONNECTION = 'connection',
        FIELD_OPTIONS = 'options'
    ;

    /**
     * @var array
     */
    private static $params = [
        self::PARAM_PROD => true,
        self::VENDOR_DOCTRINE => [
            self::FIELD_CONNECTION => [
                self::FIELD_DRIVER => 'pdo_mysql',
                self::FIELD_HOST => 'localhost',
                self::FIELD_USER => 'root',
                self::FIELD_PASS => '',
                self::FIELD_DBNAME => 'kznew',
                self::FIELD_CHARSET => 'UTF8'],
            self::FIELD_OPTIONS => [
                self::FIELD_PATH => '/models'
            ]
        ],
        self::VENDOR_TWIG => [
            self::FIELD_PATH => '/templates',
            self::FIELD_OPTIONS => ['cache' => 'compilation_cache', 'auto_reload' => true]
        ]
    ];

    /**
     * @return array
     */
    public static function getDoctrineParams()
    {
        return self::$params[self::VENDOR_DOCTRINE][self::FIELD_CONNECTION];
    }

    /**
     * @return string
     */
    public static function getDoctrineOptions()
    {
        return self::$params[self::VENDOR_DOCTRINE][self::FIELD_OPTIONS];
    }

    /**
     * @return array
     */
    public static function getTwigOptions()
    {
        return self::$params[self::VENDOR_TWIG][self::FIELD_OPTIONS];
    }

    /**
     * @return string
     */
    public static function getTwigPath()
    {
        return self::$params[self::VENDOR_TWIG][self::FIELD_PATH];
    }

    /**
     * @return bool
     */
    public static function isProd()
    {
        return self::$params[self::PARAM_PROD];
    }

}