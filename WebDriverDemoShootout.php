<?php

require_once 'vendor/autoload.php';

class WebDriverDemoShootout extends Sauce\Sausage\WebDriverTestCase
{

    protected $base_url = 'http://tutorialapp.saucelabs.com';

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
        $this->url('/register');
        $this->byId('username')->value($user['username']);
        $this->byId('password')->value($user['password']);
        $this->byId('confirm_password')->value($user['password']);
        $this->byId('name')->value($user['name']);
        $this->byId('email')->value($user['email']);
        $this->byId('email')->submit();
    }

    public function setUp()
    {
        parent::setUp();
        $this->setBrowserUrl('http://tutorialapp.saucelabs.com');
    }

    public function testLoginFailsWithBadCredentials()
    {
        $fake_username = uniqid();
        $fake_password = uniqid();

        $this->byName('login')->value($fake_username);
        $this->byName('password')->value($fake_password);
        $this->byName('password')->submit();

        $this->assertTextPresent("Failed to login.", $this->byId('message'));
    }

    public function testRegister()
    {
        $user = $this->randomUser();
        $this->doRegister($user);
        $logged_in_text = "You are logged in as {$user['username']}";
        $this->assertTextPresent($logged_in_text);
    }

}
