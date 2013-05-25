<?php
namespace BqWechatSdkTest\PushTest;

class TextTest extends AbstractPush
{
    public function getPushXml()
    {
        $xml = "
            <xml>
                 <ToUserName><![CDATA[%s]]></ToUserName>
                 <FromUserName><![CDATA[%s]]></FromUserName> 
                 <CreateTime>%d</CreateTime>
                 <MsgType><![CDATA[text]]></MsgType>
                 <Content><![CDATA[this is a test]]></Content>
                 <MsgId>1234567890123456</MsgId>
             </xml>
            ";

        $xml = sprintf(
            $xml, 
            $this->getToUserName(), 
            $this->getFromUserName(), 
            $this->getCreateTime());

        return $xml;
    }

    public function onPush($event)
    {
        parent::onPush($event);

        $message = $event->getMessage();
        $this->assertTrue($message->isText());
        $this->assertEquals('text', $message->getType());
        $this->assertEquals('this is a test', $message->getContent());
        $this->assertEquals('1234567890123456', $message->getMsgId());
    }
}
