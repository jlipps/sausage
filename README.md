sausage
=======

Your one-stop shop for everything Sauce Labs + PHP

License
-------
Sausage is available under the Apache 2 license. See `LICENSE.APACHE2` for more
details.

Install
------------
Use [Packagist](http://packagist.org/). The package name is `sauce/sausage` An example composer.json would look
like:

    {
        "require": {
            "sauce/sausage": ">=0.1.0"
        }
    }

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
