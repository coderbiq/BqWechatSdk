<?php
namespace BqWechatSdkTest\PushTextReturnTest;

use PHPUnit_Framework_TestCase;
use Zend\EventManager\EventManager;
use BqWechatSdk\Listener;
use BqWechatSdk\Event\Push;

abstract class PushTextReturnTestCase extends PHPUnit_Framework_TestCase
{
    protected $eventManager;
    protected $triggerPush = false;

    public function setup()
    {
        $GLOBALS["HTTP_RAW_POST_DATA"] = "
            <xml>
                 <ToUserName><![CDATA[toUser]]></ToUserName>
                 <FromUserName><![CDATA[fromUser]]></FromUserName> 
                 <CreateTime>123456789</CreateTime>
                 <MsgType><![CDATA[text]]></MsgType>
                 <Content><![CDATA[this is a test]]></Content>
                 <MsgId>1234567890123456</MsgId>
             </xml>
            ";
        $this->eventManager = new EventManager();
        $this->eventManager->attach(Push::EVENT_PUSH, array($this, 'onPush'));
    }

    protected function getOutput()
    {
        $listenner = new Listener();

        ob_start();
        $listenner->setEventManager($this->eventManager)->run();
        $output = ob_get_contents();
        ob_end_clean();

        $outputObj = simplexml_load_string(
            $output, 
            'SimpleXMLElement', 
            LIBXML_NOCDATA);

        return $outputObj;
    }
}
