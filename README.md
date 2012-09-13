sausage
=======

A PHP framework for the Sauce Labs REST API

Install
------------
Use [Packagist](http://packagist.org/). The package name is `Sauce/Sausage` An example composer.json would look
like:

    {
        "require": {
            "Sauce/Sausage": ">=0.1.0"
        }
    }

Use
---
    <?php 

    $s = new Sauce\Sausage\Sausage('myusername', 'myapikey');

    $my_details = $s->getAccountDetails();

    $most_recent_test = $s->getJobs(0)['jobs'][0];
    $s->updateJob($most_recent_test['id'], array('passed' => true));

    $browser_list = $s->getAllBrowsers();
    foreach ($browser_list as $browser)
        echo "${browser['long_name']} ${browser['short_version']}
        ${browser['os'}";

See `Sauce/Sausage/API.php` for the list of Sauce API functions (currently
boasting 100% support). Also check out `test.php` for other examples.

Contribute
---

Send in all the pull requests!
