<?php

namespace Sauce;

define('SAUCE_API_PREFIX', '/rest/v1/');

class API
{

    protected $username;

    protected static $user_fields = array(
        'username',
        'name',
        'email',
        'password'
    );

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

    protected function requireParams(array $params)
    {
        foreach ($params as $param_set)
            call_user_func_array(array($this, 'requireParam'), $param_set);
    }

    /* user methods */

    public function getAccountDetails()
    {
        return array(SAUCE_API_PREFIX.'users/'.$this->username);
    }

    public function getAccountLimits()
    {
        return array(SAUCE_API_PREFIX.$this->username.'/limits');
    }

    public function createUser($user_details)
    {
        throw new \Exception("Create user is only for authorized partners");
    }

    public function createSubaccount(array $subacct_details)
    {
        $this->requireParam("subacct_details", $subacct_details);

        foreach ($subacct_details as $key => $val)
            if (!in_array($key, self::$user_fields))
                throw new \Exception("$key is not a valid subaccount field");

        foreach (self::$user_fields as $key)
            if (!isset($subacct_details[$key]))
                throw new \Exception("$key is a required subaccount field");

        return array(
            SAUCE_API_PREFIX.'users/'.$this->username,
            "POST",
            $subacct_details
        );
    }

    /* job methods */

    public function updateJob($job_id, $job_details)
    {
        $this->requireParams(array(
            array("job_id", $job_id),
            array("job_details", $job_details)
        ));

        return array(
            SAUCE_API_PREFIX.$this->username.'/jobs/'.$job_id,
            "PUT",
            $job_details
        );

    }
}
