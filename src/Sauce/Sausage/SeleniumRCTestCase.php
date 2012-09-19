<?php

namespace Sauce\Sausage;

abstract class SeleniumRCTestCase extends \PHPUnit_Extensions_SeleniumTestCase
{

    protected $job_id;

    public function setupSpecificBrowser($browser)
    {
        $this->getDriver($browser);
        self::ShareSession(false);
    }

    protected function getDriver(array $browser)
    {
        SauceTestCommon::RequireSauceConfig();

        $defaults = array(
            'browser' => 'firefox',
            'browserVersion' => '11',
            'os' => 'Windows 2008',
            'timeout' => 30,
            'httpTimeout' => 45,
            'name' => get_called_class().'::'.$this->getName(),
        );

        $browser = array_merge($defaults, $browser);
        $checks = array(
            'name' => 'string',
            'browser' => 'string',
            'browserVersion' => 'string',
            'timeout' => 'int',
            'httpTimeout' => 'int',
            'os' => 'string'
        );

        foreach ($checks as $key => $type) {
            $func = 'is_'.$type;
            if (!$func($browser[$key])) {
                throw new InvalidArgumentException(
                    'Array element "'.$key.'" is no '.$type.'.'
                );
            }
        }

        $driver = new SeleniumRCDriver();
        $driver->setName($browser['name']);
        $driver->setUsername(SAUCE_USERNAME);
        $driver->setAccessKey(SAUCE_API_KEY);
        $driver->setOs($browser['os']);
        $driver->setBrowser($browser['browser']);
        $driver->setBrowserVersion($browser['browserVersion']);
        $driver->setHost('ondemand.saucelabs.com');
        $driver->setPort(80);
        $driver->setTimeout($browser['timeout']);
        $driver->setHttpTimeout($browser['httpTimeout']);
        $driver->setTestCase($this);
        $driver->setTestId($this->testId);

        $this->drivers[0] = $driver;

        return $driver;
    }

    protected function prepareTestSession()
    {
        $this->job_id = parent::prepareTestSession();
        //$this->setContext("sauce:job-name=".get_called_class().'::'.$this->getName());
        $this->postSessionSetUp();
        return $this->job_id;
    }

    protected function postSessionSetUp()
    {
    }


    public function tearDown()
    {
        SauceTestCommon::ReportStatus($this->job_id, !$this->hasFailed());
    }

    public function spinAssert($msg, $test, $args=array(), $timeout=10)
    {
        list($result, $msg) = SauceTestCommon::SpinAssert($msg, $test, $args, $timeout);
        $this->assertTrue($result, $msg);
    }

}
