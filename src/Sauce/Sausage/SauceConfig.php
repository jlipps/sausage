<?php

namespace Sauce\Sausage;

define('CONFIG_PATH', dirname(__FILE__).'/../../../.sauce_config');

class SauceConfig
{

    public static function LoadConfig()
    {
        if (!defined('SAUCE_USERNAME') && !defined('SAUCE_API_KEY')) {
            if (is_file(CONFIG_PATH)) {
                $config = file_get_contents(CONFIG_PATH);
                list($username, $api_key) = split(',', $config);
                $username = trim($username);
                $api_key = trim($api_key);
            } elseif (getenv('SAUCE_USERNAME') && getenv('SAUCE_ACCESS_KEY')) {
                $username = getenv('SAUCE_USERNAME');
                $api_key = getenv('SAUCE_API_KEY');
            }
            define('SAUCE_USERNAME', $username);
            define('SAUCE_API_KEY', $api_key);
        }
    }

    public static function GetConfig()
    {
        self::LoadConfig();
        $username = defined('SAUCE_USERNAME') ? SAUCE_USERNAME : '';
        $api_key = defined('SAUCE_API_KEY') ? SAUCE_API_KEY : '';
        return array($username, $api_key);
    }

    public static function WriteConfig($username, $api_key) {
        file_put_contents(CONFIG_PATH, "{$username},{$api_key}");
    }

}
