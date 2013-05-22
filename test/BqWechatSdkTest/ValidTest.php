<?php
namespace BqWechatSdkTest;

use PHPUnit_Framework_TestCase;
use Zend\EventManager\EventManager;
use BqWechatSdk\Listener;
use BqWechatSdk\Event\Listener\Valid;

class ValidTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $token = 'test';
        $_GET['echostr'] = 'abcd';
        $_GET['timestamp'] = time();
        $_GET['nonce'] = 'ert';

        $_GET["signature"] = array($token, $_GET['timestamp'], $_GET['nonce']);
        sort($_GET["signature"]);
        $_GET["signature"] = implode( $_GET["signature"] );
        $_GET["signature"] = sha1( $_GET["signature"] );
    }

    public function testValid()
    {
        $listener = new Listener();
        $eventManager = new EventManager();
        $validListener = new Valid();
        $validListener->setToken('test');
        $eventManager->attach($validListener);

        ob_start();
        $listener->setEventManager($eventManager)->run();
        $output = ob_get_contents();
        $this->assertEquals('abcd', $output);
        ob_end_clean();
    }
}
