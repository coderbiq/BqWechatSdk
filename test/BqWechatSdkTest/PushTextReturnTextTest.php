<?php
namespace BqWechatSdkTest;

use PHPUnit_Framework_TestCase;
use Zend\EventManager\EventManager;
use BqWechatSdk\Listener;
use BqWechatSdk\Event\Push;
use BqWechatSdk\Message;
use BqWechatSdk\Event\Result;

class PushTextReturnTextTest extends PHPUnit_Framework_TestCase
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

    public function testPushTextReturnText()
    {
        $listenner = new Listener();

        ob_start();
        $listenner->setEventManager($this->eventManager)->run();
        $output = ob_get_contents();
        $outputObj = simplexml_load_string(
            $output, 
            'SimpleXMLElement', 
            LIBXML_NOCDATA);
        $this->assertInstanceOf('SimpleXMLElement', $outputObj);
        $this->assertEquals('text', $outputObj->MsgType);
        $this->assertEquals('test content', $outputObj->Content);
        $this->assertEquals('0', $outputObj->FuncFlag);
        $this->assertEquals('123456789', $outputObj->CreateTime);
        $this->assertEquals('fromUser', $outputObj->FromUserName);
        $this->assertEquals('toUser', $outputObj->ToUserName);
        ob_end_clean();
    }

    public function onPush($event)
    {
        $message = new Message();
        $message
            ->setType(Message::TYPE_TEXT)
            ->setFromUserName('fromUser')
            ->setToUserName('toUser')
            ->setContent('test content')
            ->setCreateTime(123456789)
            ->setFuncFlag(0);
        $result = new Result();
        $result->setMessage($message);
        return $result;
    }
}
