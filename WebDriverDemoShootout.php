<?php

require_once 'vendor/autoload.php';

class WebDriverDemoShootout extends Sauce\Sausage\WebDriverTestCase
{
    public static $browsers = array(
        array(
            'browserName' => 'chrome',
            'local' => true
        )
    );

    protected function randomUser()
    {
        $id = uniqid();
        return array(
            'username' => "fakeuser_$id",
            'password' => 'testpass',
            'name' => "Fake $id",
            'email' => "$id@fake.com"
        );
    }

    protected function doRegister($user)
    {
    }

    public function setUp()
    {
        parent::setUp();
        $this->setBrowserUrl('http://tutorialapp.saucelabs.com');
    }

    public function testLoginFails()
    {
        $fake_username = uniqid();
        $fake_password = uniqid();

        $this->byName('login')->value($fake_username);
        $this->byName('password')->value($fake_password);
        $this->byName('password')->submit();

        $this->assertTextPresent("Failed to login.", $this->byId('message'));
    }
}
