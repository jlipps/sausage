<?php

namespace Sauce;

define('SAUCE_API_PREFIX', '/rest/v1/');

class API
{

    protected $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    protected function requireParam($param_name, $param_val,
        $check_truthiness=true)
    {
        if($param_val == NULL || ($check_truthiness && !$param_val))
            throw new \Exception("$param_name is required");
    }

    public function updateJob($job_id, $job_details)
    {
        return array(
            SAUCE_API_PREFIX.$this->username.'/jobs/'.$job_id,
            "PUT",
            $job_details
        );

    }
}
