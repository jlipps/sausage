sausage
=======

A PHP framework for the Sauce Labs REST API

Installation
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

    $recent_tests = $s->getJobs();
    $most_recent_test = $recent_tests[0];
    $s->updateJob()
