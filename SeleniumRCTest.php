<?php

require_once 'Sauce/Sausage/SeleniumRCTestCase.php';

define('SAUCE_USERNAME', getenv('SAUCE_USERNAME'));
define('SAUCE_ACCESS_KEY', getenv('SAUCE_ACCESS_KEY'));

class WebDriverTest extends Sauce\Sausage\SeleniumRCTestCase
{
    public static $browsers = array(
        array(
            'browser' => 'firefox',
            'browserVersion' => '15',
            'os' => 'Windows 2008'
        )
    );

    public function setUp()
    {
        parent::setUp();
        $this->open('http://saucelabs.com/test/guinea-pig');
    }

    public function testTitle()
    {
        $this->assertTitle("I am a page title");
    }
}
