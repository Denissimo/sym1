<?php

namespace App\Cfg;

class Config
{
    const
        PARAM_PROD = 'production',
        PARAM_GRANTED = 'granted_uris',
        PARAM_AUTORIZE = 'autorize',
        VENDOR_DOCTRINE = 'doctrine',
        VENDOR_LOGGER = 'logger',
        VENDOR_TWIG = 'twig';

    const
        REQUEST_USER = 'req_user',
        REQUEST_PASS = 'req_pass';

    const
        FIELD_OBLIG = 'obligatory',
        FIELD_LOGIN = 'login',
        FIELD_DRIVER = 'driver',
        FIELD_HOST = 'host',
        FIELD_USER = 'user',
        FIELD_NAME = 'name',
        FIELD_PASS = 'password',
        FIELD_TABLE = 'table',
        FIELD_DBNAME = 'dbname',
        FIELD_CHARSET = 'charset',
        FIELD_DEFAULT = 'default',
        FIELD_PATH = 'path',
        FIELD_FILE = 'file',
        FIELD_CONNECTION = 'connection',
        FIELD_UID = 'uid',
        FIELD_OPTIONS = 'options'
    ;

    /**
     * @var array
     */
    private static $params = [
        self::PARAM_PROD => true,
        self::PARAM_AUTORIZE => [
            self::FIELD_OBLIG => true,
            self::FIELD_TABLE => 'Users',
            self::FIELD_USER => 'email',
            self::FIELD_PASS => 'password',
            self::REQUEST_USER => 'user',
            self::REQUEST_PASS => 'pass'
        ],
        self::VENDOR_DOCTRINE => [
            self::FIELD_CONNECTION => [
                self::FIELD_DRIVER => 'pdo_mysql',
                self::FIELD_HOST => 'localhost',
                self::FIELD_USER => 'kz',
                self::FIELD_PASS => 'kz221459',
                self::FIELD_DBNAME => 'kz',
                self::FIELD_CHARSET => 'UTF8'],
            self::FIELD_OPTIONS => [
                self::FIELD_PATH => '/models'
            ]
        ],
        self::VENDOR_TWIG => [
            self::FIELD_PATH => '/templates',
            self::FIELD_DEFAULT => 'default.html.twig',
            self::FIELD_LOGIN => 'login.html.twig',
            self::FIELD_OPTIONS => ['cache' => 'compilation_cache', 'auto_reload' => true]
        ],
        self::VENDOR_LOGGER => [
            self::FIELD_PATH => __DIR__.'/../../logs/'
        ],
        self::PARAM_GRANTED =>[
            '/api',
            '/postlog'
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
     * @return string
     */
    public static function getTwigDefaultTemplate()
    {
        return self::$params[self::VENDOR_TWIG][self::FIELD_DEFAULT];
    }

    /**
     * @return string
     */
    public static function getTwigLoginTemplate()
    {
        return self::$params[self::VENDOR_TWIG][self::FIELD_LOGIN];
    }

    /*
    * @return array
    */
    public static function getAutorizeParams()
    {
        return self::$params[self::PARAM_AUTORIZE];
    }
    /*
    * @return array
    */
    public static function getGrantedUris()
    {
        return self::$params[self::PARAM_GRANTED];
    }

    /*
    * @return string
    */
    public static function getRequestUserField()
    {
        return self::$params[self::PARAM_AUTORIZE][Config::REQUEST_USER];
    }

    /*
    * @return string
    */
    public static function getRequestPassField()
    {
        return self::$params[self::PARAM_AUTORIZE][Config::REQUEST_PASS];
    }

    /*
    * @return string
    */
    public static function getDbUserField()
    {
        return self::$params[self::PARAM_AUTORIZE][Config::FIELD_USER];
    }

    /*
    * @return string
    */
    public static function getDbPassField()
    {
        return self::$params[self::PARAM_AUTORIZE][Config::FIELD_PASS];
    }

    /*
    * @return bool
    */
    public static function isAutorizeObligatory()
    {
        return self::$params[self::PARAM_AUTORIZE][self::FIELD_OBLIG];
    }

    /**
     * @return bool
     */
    public static function isProd()
    {
        return self::$params[self::PARAM_PROD];
    }

    /*
    * @return string
    */
    public static function getLoggerPath()
    {
        return self::$params[self::VENDOR_LOGGER][Config::FIELD_PATH];
    }

}