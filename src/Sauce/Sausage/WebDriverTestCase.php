<?php
namespace Sauce\Sausage;

abstract class WebDriverTestCase extends \PHPUnit_Extensions_Selenium2TestCase
{

    public function setUp()
    {
        $caps = $this->getDesiredCapabilities();
        if (!isset($caps['name'])) {
            $caps['name'] = get_called_class().'::'.$this->getName();
            $this->setDesiredCapabilities($caps);
        }
    }

    public function setupSpecificBrowser($params)
    {
        SauceTestCommon::RequireSauceConfig();

        // Give some nice defaults
        if (!isset($params['seleniumServerRequestsTimeout']))
            $params['seleniumServerRequestsTimeout'] = 60;

        if (!isset($params['browserName'])) {
            $params['browserName'] = 'chrome';
            $params['desiredCapabilities'] = array(
                'version' => '',
                'os' => 'VISTA'
            );
        }

        // Setting 'local' gives us nice defaults of localhost:4444
        $local = (isset($params['local']) && $params['local']);

        // Set up host
        $sauce_host = SAUCE_USERNAME.':'.SAUCE_API_KEY.'@ondemand.saucelabs.com';
        $host = isset($params['host']) ? $params['host'] : false;
        $this->setHost($host ? $host : ($local ? 'localhost' : $sauce_host));

        // Set up port
        $port = isset($params['port']) ? $params['port'] : false;
        $this->setPort($port ? $port : ($local ? 4444 : 80));

        // Set up other params
        $this->setBrowser($params['browserName']);
        $caps = isset($params['desiredCapabilities']) ? $params['desiredCapabilities'] : array();
        $this->setDesiredCapabilities($caps);
        $this->setSeleniumServerRequestsTimeout(
            $params['seleniumServerRequestsTimeout']);

        // If we're using Sauce, make sure we don't try to share browsers
        if (!$local && !$host && isset($params['sessionStrategy'])) {
            $params['sessionStrategy'] = 'isolated';
        }

        $this->setUpSessionStrategy($params);
    }

    public function tearDown()
    {
        SauceTestCommon::ReportStatus($this->getSessionId(), !$this->hasFailed());
    }

    public function spinAssert($msg, $test, $args=array(), $timeout=10)
    {
        list($result, $msg) = SauceTestCommon::SpinAssert($msg, $test, $args, $timeout);
        $this->assertTrue($result, $msg);
    }

}
