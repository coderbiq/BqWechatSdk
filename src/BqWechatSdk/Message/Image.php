<?php
namespace BqWechatSdk\Message;

use BqWechatSdk\Message;

class Image extends AbstractMessage
{
    public function getType()
    {
        return Message::TYPE_IMAGE;
    }

    public function getMsgId()
    {
        return $this->postData->MsgId;
    }

    public function getPicUrl()
    {
        return $this->postData->PicUrl;
    }

}
