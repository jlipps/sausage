Sausage
=======

Your one-stop shop for everything Selenium + Sauce Labs + PHP. This is a set of
classes and libraries that make it easy to run your Selenium tests, either
locally or on Sauce Labs. You run the tests with [PHPUnit](http://phpunit.de).

Sausage comes bundled with [Paraunit](http://github.com/jlipps/paraunit) (for 
running your PHPUnit tests in parallel) and 
[Sauce Connect](http://saucelabs.com/docs/connect) (for testing locally-hosted 
sites with Sauce).

Read the rest of this page for installation and usage instructions designed 
to help you get the most out of your sausage.

License
-------
Sausage is available under the Apache 2 license. See `LICENSE.APACHE2` for more
details.

Quickstart
----------
Check out [sausage-bun](http://github.com/jlipps/sausage-bun). It's a one-line 
script you can run via curl and PHP to get everything going.

Manual Install
------------
Sausage is distributed as a [Composer](http://getcomposer.org) package via 
[Packagist](http://packagist.org/), 
under the package `sauce/sausage`. To get it, add (or update) the `composer.json` 
file in your project root. A minimal example composer.json would look like:

    {
        "require": {
            "sauce/sausage": "dev-master"
        },
        "minimum-stability": "dev"
    }

If you haven't already got Composer installed, get it thusly:

    curl -s http://getcomposer.org/installer | php

Then, install the packages (or `update` if you've already set up Composer):

    php composer.phar install

This will install Sausage and all its dependences (like PHPUnit, etc...). If 
you didn't already have the `SAUCE_USERNAME` and `SAUCE_ACCESS_KEY` environment
variables set, you'll now need to configure Sausage for use with your Sauce 
account:

    vendor/bin/sauce_config YOUR_SAUCE_USERNAME YOUR_SAUCE_API_KEY

(It's a Composer convention for package binaries to be located in `vendor/bin`;
you can always symlink things elsewhere if it's more convenient).

Sauce Labs API
---
    <?php 

    $s = new Sauce\Sausage\SauceAPI('myusername', 'myapikey');

    $my_details = $s->getAccountDetails();

    $most_recent_test = $s->getJobs(0)['jobs'][0];
    $s->updateJob($most_recent_test['id'], array('passed' => true));

    $browser_list = $s->getAllBrowsers();
    foreach ($browser_list as $browser) {
        $name = $browser['long_name'];
        $ver = $browser['short_version'];
        $os = $browser['os'];
        echo "$name $ver $os\n";
    }

See `Sauce/Sausage/SauceMethods.php` for the list of Sauce API functions (currently
boasting 100% support). Also check out `sauce_api_test.php` for other examples.

PHPUnit Extensions
------------------

Selenium much? Check out `WebDriverTestCase.php` or `SeleniumRCTestCase.php`.
The easiest way to use Selenium with PHPUnit. Automatically handles reporting
pass/fail status to Sauce and gives you the power of SpinAsserts!

Check out `WebDriverDemo.php` or `SeleniumRCDemo.php` to see how awesome it is.

Contribute
---

Send in all the pull requests!
