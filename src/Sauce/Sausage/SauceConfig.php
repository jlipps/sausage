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
                list($username, $access_key) = split(',', $config);
                $username = trim($username);
                $access_key = trim($access_key);
            } elseif (getenv('SAUCE_USERNAME') && getenv('SAUCE_ACCESS_KEY')) {
                $username = getenv('SAUCE_USERNAME');
                $access_key = getenv('SAUCE_ACCESS_KEY');
            }
            define('SAUCE_USERNAME', $username);
            define('SAUCE_API_KEY', $access_key);
        }
    }

}
