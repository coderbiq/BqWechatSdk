<?php
namespace BqWechatSdk\Message;

use BqWechatSdk\Message;

class Link extends AbstractMessage
{
    public function getType()
    {
        return Message::TYPE_LINK;
    }

    public function getMsgId()
    {
        return $this->postData->MsgId;
    }

    public function getTitle()
    {
        return $this->postData->Title;
    }

    public function getDescription()
    {
        return $this->postData->Description;
    }

    public function getUrl()
    {
        return $this->postData->Url;
    }
}
