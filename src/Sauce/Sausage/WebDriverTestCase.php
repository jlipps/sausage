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

        if (!isset($params['seleniumServerRequestsTimeout']))
            $params['seleniumServerRequestsTimeout'] = 60;

        if (!isset($params['browserName']))
            $params['browserName'] = 'chrome';

        if (!isset($params['desiredCapabilities'])) {
            $params['desiredCapabilities'] = array(
                'version' => '*',
                'os' => 'VISTA'
            );
        }

        $host = SAUCE_USERNAME.':'.SAUCE_ACCESS_KEY.'@ondemand.saucelabs.com';
        $this->setHost($host);
        $this->setPort(80);
        $this->setBrowser($params['browserName']);
        $this->setDesiredCapabilities($params['desiredCapabilities']);
        $this->setSeleniumServerRequestsTimeout(
            $params['seleniumServerRequestsTimeout']);
        $this->localSessionStrategy = false;
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
