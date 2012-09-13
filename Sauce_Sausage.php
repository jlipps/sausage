<?php
namespace Sauce;

require_once("Sauce_Sausage_API.php");

define('SAUCE_HOST', 'saucelabs.com');

class Sausage
{

    protected $username;
    protected $api_key;

    public function __construct($username, $api_key)
    {
        $this->username = $username;
        $this->api_key = $api_key;
        $this->api = new API($this->username);
    }

    protected function buildUrl($endpoint, $secure=true)
    {
        $host = SAUCE_HOST;
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
            throw new \Exception("Got an error while making a request: ".curl_error($ch));

        curl_close($ch);

        print_r($response);

        $json = json_decode($response);

        if (!$json) {
            throw new \Exception("An error occurred parsing the response. ".
                                "Please check your parameters and try again");
        }

        return $json;
    }

    public function __call($command, $args)
    {
        $res = call_user_func_array(array($this->api, $command), $arguments);
        list($endpoint, $request_type, $request_params) = $res;
        $url = $this->buildUrl($endpoint);
        return $this->makeRequest($url, $request_type, $request_params);
    }



}
