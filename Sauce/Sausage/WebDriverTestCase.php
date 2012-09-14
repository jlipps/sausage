<?php
namespace Sauce\Sausage;

require_once 'PHPUnit/Extensions/Selenium2TestCase.php';
require_once dirname(__file__).'/SauceAPI.php';

abstract class WebDriverTestCase extends \PHPUnit_Extensions_Selenium2TestCase
{

    protected $api = false;

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
        if (!defined('SAUCE_USERNAME') || !SAUCE_USERNAME) {
            throw new \Exception("SAUCE_USERNAME must be defined!");
        }

        if (!defined('SAUCE_ACCESS_KEY') || !SAUCE_ACCESS_KEY) {
            throw new \Exception("SAUCE_ACCESS_KEY must be defined!");
        }

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
        $this->api = new SauceAPI(SAUCE_USERNAME, SAUCE_ACCESS_KEY);
        $status = !$this->hasFailed();
        $this->api->updateJob($this->getSessionId(), array('passed'=>$status));
    }

    public function spinAssert()
    {
    }

}
