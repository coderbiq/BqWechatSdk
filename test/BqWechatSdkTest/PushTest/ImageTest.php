<?php
namespace BqWechatSdkTest\PushTest;

class ImageTest extends AbstractPush
{
    public function getPushXml()
    {
        $xml = "
            <xml>
                 <ToUserName><![CDATA[%s]]></ToUserName>
                 <FromUserName><![CDATA[%s]]></FromUserName>
                 <CreateTime>%d</CreateTime>
                 <MsgType><![CDATA[image]]></MsgType>
                 <PicUrl><![CDATA[this is a url]]></PicUrl>
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
        $this->assertTrue($message->isImage());
        $this->assertEquals('this is a url', $message->getPicUrl());
        $this->assertEquals('1234567890123456', $message->getMsgId());
    }
}
