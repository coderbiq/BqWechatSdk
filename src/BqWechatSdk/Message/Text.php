<?php
namespace BqWechatSdk\Message;

use BqWechatSdk\Message;

class Text extends AbstractMessage
{
    public function getType()
    {
        return Message::TYPE_TEXT;
    }

    public function getMsgId()
    {
        return $this->postData->MsgId;
    }

    public function getContent()
    {
        return $this->getData('content', 'Content');
    }

    public function setContent($content)
    {
        $this->data['content'] = $content;
        return $this;
    }

    public function toXmlString()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%d</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>%d</FuncFlag>
            </xml>
            ";

        return sprintf(
            $xml, 
            $this->getToUserName(), 
            $this->getFromUserName(),
            $this->getCreateTime(),
            $this->getContent(),
            $this->getFuncFlag()
        );

    }
}
