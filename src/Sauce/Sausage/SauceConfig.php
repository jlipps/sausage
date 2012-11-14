<?php

namespace Sauce\Sausage;

define('CONFIG_PATH', dirname(__FILE__).'/../../../.sauce_config');

class SauceConfig
{

    public static function LoadConfig($fail_if_no_config = true)
    {
        if (!defined('SAUCE_USERNAME') && !defined('SAUCE_ACCESS_KEY')) {
            if (is_file(CONFIG_PATH)) {
                $config = file_get_contents(CONFIG_PATH);
                list($username, $access_key) = explode(',', $config);
                $username = trim($username);
                $access_key = trim($access_key);
            } elseif (getenv('SAUCE_USERNAME') && getenv('SAUCE_ACCESS_KEY')) {
                $username = getenv('SAUCE_USERNAME');
                $access_key = getenv('SAUCE_ACCESS_KEY');
            } elseif ($fail_if_no_config) {
                $msg = <<<EOF
We could not find your Sauce username or access key (which you can get from
https://saucelabs.com/account). You have two options for setting them:

1) run vendor/bin/sauce_config USERNAME access_kEY
2) export environment variables SAUCE_USERNAME and SAUCE_ACCESS_KEY

Please take one of these two steps and try again!
EOF;
                echo $msg;
                exit(1);
            } else {
                $username = $access_key = NULL;
            }

            define('SAUCE_USERNAME', $username);
            define('SAUCE_ACCESS_KEY', $access_key);
        }
        if (!defined('SAUCE_BUILD') && getenv('SAUCE_BUILD')) {
            define('SAUCE_BUILD', getenv('SAUCE_BUILD'));
        }
    }

    public static function GetConfig($fail_if_no_config = true)
    {
        self::LoadConfig($fail_if_no_config);
        return array(SAUCE_USERNAME, SAUCE_ACCESS_KEY);
    }

    public static function GetBuild()
    {
        self::LoadConfig(false);
        if (defined('SAUCE_BUILD')) {
            return SAUCE_BUILD;
        }
        return false;
    }

    public static function WriteConfig($username, $access_key) {
        file_put_contents(CONFIG_PATH, "{$username},{$access_key}");
    }

}
