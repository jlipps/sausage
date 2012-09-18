<?php

require_once 'vendor/autoload.php';

class WebDriverDemo extends Sauce\Sausage\WebDriverTestCase
{
    public static $browsers = array(
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'version' => '15',
                'os' => 'VISTA'
            )
        )
        //array(
            //'browserName' => 'chrome',
            //'desiredCapabilities' => array(
                //'os' => 'Linux'
          //)
        //)
    );

    public function setUp()
    {
        parent::setUp();
        $this->setBrowserUrl('http://saucelabs.com/test/guinea-pig');
    }

    public function testTitle()
    {
        $this->assertContains("I am a page title", $this->title());
    }

    public function testLink()
    {
        $link = $this->byId('i am a link');
        $link->click();
        $this->assertContains("I am another page title", $this->title());
    }

    public function testTextbox()
    {
        $test_text = "This is some text";
        $textbox = $this->byId('i_am_a_textbox');
        $textbox->click();
        $this->keys($test_text);
        $this->assertEquals($textbox->value(), $test_text);
    }

    public function testSubmitComments()
    {
        $comment = "This is a very insightful comment.";
        $this->byId('comments')->click();
        $this->keys($comment);
        $this->byId('submit')->submit();
        $driver = $this;

        $comment_test =
            function() use ($comment, $driver)
            {
                return ($driver->byId('your_comments')->text() == "Your comments: $comment");
            }
        ;

        $this->spinAssert("Comment never showed up!", $comment_test);

    }

}
