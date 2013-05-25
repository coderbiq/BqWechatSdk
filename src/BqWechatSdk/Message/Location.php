<?php
namespace BqWechatSdk\Message;

use BqWechatSdk\Message;

class Location extends AbstractMessage
{
    public function getType()
    {
        return Message::TYPE_LOCATION;
    }

    public function getMsgId()
    {
        return $this->postData->MsgId;
    }

    public function getLat()
    {
        return $this->postData->Location_X;
    }

    public function getLon()
    {
        return $this->postData->Location_Y;
    }

    public function getScale()
    {
        return $this->postData->Scale;
    }

    public function getLabel()
    {
        return $this->postData->Label;
    }
}
