<?php

namespace Sauce\Sausage;

require_once 'PHPUnit/Extensions/SeleniumTestCase/Driver.php';

abstract class SeleniumRCDriver extends \PHPUnit_Extensions_SeleniumTestCase_Driver
{

    protected $os;

    protected $browser_version;

    protected $username;

    protected $access_key;

    public function start()
    {
        if ($this->browserUrl == NULL) {
            throw new PHPUnit_Framework_Exception(
              'setBrowserUrl() needs to be called before start().'
            );
        }

        if ($this->username == NULL) {
            throw new PHPUnit_Framework_Exception(
              'setUsername() needs to be called before start().'
            );
        }

        if ($this->access_key == NULL) {
            throw new PHPUnit_Framework_Exception(
              'setAccessKey() needs to be called before start().'
            );
        }

        if ($this->browser == NULL) {
            throw new PHPUnit_Framework_Exception(
              'setBrowser() needs to be called before start().'
            );
        }

        if ($this->browser_version == NULL) {
            throw new PHPUnit_Framework_Exception(
              'setBrowserVersion() needs to be called before start().'
            );
        }

        if ($this->os == NULL) {
            throw new PHPUnit_Framework_Exception(
              'setOs() needs to be called before start().'
            );
        }

        if ($this->webDriverCapabilities !== NULL) {
            throw new \PHPUnit_Framework_Exception(
                'Sauce extensions of PHP do not allow webDriverCapabilities'
            );
        }

        $data = array(
            'username'        => $this->username,
            'access-key'      => $this->access_key,
            'os'              => $this->os,
            'browser'         => $this->browser,
            'browser-version' => $this->browser_version,
        );

        $this->sessionId = $this->getString(
          'getNewBrowserSession',
          array(json_encode($data), $this->browserUrl)
        );

        $this->doCommand('setTimeout', array($this->seleniumTimeout * 1000));

        return $this->sessionId;
    }

    public function setUsername($username)
    {
        if (!is_string($username)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        $this->username = $username;
    }

    public function setAccessKey($key)
    {
        if (!is_string($key)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        $this->access_key = $key;
    }

    public function setBrowserVersion($ver)
    {
        if (!is_string($ver)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        $this->browser_version = $ver;
    }

    public function setOs($os)
    {
        if (!is_string($os)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        $this->os = $os;
    }

}
