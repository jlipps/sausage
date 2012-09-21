<?php

namespace Sauce\Sausage;

define('CONFIG_PATH', dirname(__FILE__).'/../../../.sauce_config');

class SauceConfig
{

    public static function LoadConfig($fail_if_no_config = true)
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
            } elseif ($fail_if_no_config) {
                $msg = <<<EOF
We could not find your Sauce username or API key (which you can get from
https://saucelabs.com/account). You have two options for setting them:

1) run vendor/bin/sauce_config USERNAME API_KEY
2) export environment variables SAUCE_USERNAME and SAUCE_ACCESS_KEY

Please take one of these two steps and try again!
EOF;
                echo $msg;
                exit(1);
            } else {
                $username = $api_key = NULL;
            }

            define('SAUCE_USERNAME', $username);
            define('SAUCE_API_KEY', $api_key);
        }
    }

    public static function GetConfig($fail_if_no_config = true)
    {
        self::LoadConfig($fail_if_no_config);
        return array(SAUCE_USERNAME, SAUCE_API_KEY);
    }

    public static function WriteConfig($username, $api_key) {
        file_put_contents(CONFIG_PATH, "{$username},{$api_key}");
    }

}
