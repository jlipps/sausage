<?php
namespace Sauce;

class Sausage {

    protected $username;
    protected $api_key;

    public function __construct($username, $api_key)
    {
        $this->username = $username;
        $this->api_key = $api_key;
    }

    protected function buildUrl($endpoint, $secure=true)
    {
        $host = 'saucelabs.com';
        if ($secure)
            $host = $this->username.':'.$this->api_key.'@'.$host;
        if ($endpoint[0] != '/')
            $endpoint = '/'.$endpoint;

        return 'http://'.$host.$endpoint;
    }

    protected function makeRequest($url, $type="POST", $params=array())
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($type == "POST")
            curl_setopt($ch, CURLOPT_POST, 1);
        elseif ($type == "PUT")
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        elseif ($type == "DELETE")
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $headers = array();
        $headers[] = 'Content-Type: text/json';

        if ($params) {
            $data = json_encode($params);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $headers[] = 'Content-length:'.strlen($data);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch))
            throw new Exception("Got an error while making a request: ".curl_error($ch));

        curl_close($ch);

        return json_decode($response);
    }

    public function updateJob($job_id, $job_details)
    {
        if (!$job_id)
            throw new Exception("Job id is required for updating a job!");

        $url = $this->buildUrl('/rest/v1/'.$this->username.'/jobs/'.$job_id);
        $res = $this->makeRequest($url, "PUT", $job_details);
    }


}
