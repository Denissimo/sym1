<?php

namespace App\Api;

class Config
{

    /**
     * @var array
     */
    private static $config;
	private static $instance = null;

    private function __construct()
    {
        self::$config = self::parseConfigItems('', parse_ini_file(__DIR__ . '/../../config/config.ini', true));
    }

    private static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
	
    private static function parseConfigItems($prefix, $items)
    {
        $output = array();
        $prefix2 = $prefix == "" ? "" : ($prefix . '.');
        foreach ($items as $key => $item) {
            if (is_array($item)) {
                $output = array_merge($output, self::parseConfigItems($prefix2 . $key, $item));
            }

            $output[$prefix2 . $key] = $item;
        }

        return $output;
    }


    public static function get($key)
    {
        self::getInstance();
		if (array_key_exists($key, self::$config)) {
            return self::$config[$key];
        } else {
            return null;
        }
    }
}
