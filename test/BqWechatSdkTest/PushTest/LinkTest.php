<?php
namespace BqWechatSdkTest\PushTest;

class LinkTest extends AbstractPush
{
    public function getPushXml()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%d</CreateTime>
                <MsgType><![CDATA[link]]></MsgType>
                <Title><![CDATA[公众平台官网链接]]></Title>
                <Description><![CDATA[公众平台官网链接]]></Description>
                <Url><![CDATA[url]]></Url>
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
        $this->assertTrue($message->isLink());
        $this->assertEquals('公众平台官网链接', $message->getTitle());
        $this->assertEquals('公众平台官网链接', $message->getDescription());
        $this->assertEquals('url', $message->getUrl());
        $this->assertEquals('1234567890123456', $message->getMsgId());
    }
}
