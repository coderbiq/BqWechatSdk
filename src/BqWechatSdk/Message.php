<?php
namespace BqWechatSdk;

class Message
{
    const TYPE_TEXT     = 'text';
    const TYPE_IMAGE    = 'image';
    const TYPE_LOCATION = 'location';
    const TYPE_LINK     = 'link';
    const TYPE_EVENT    = 'event';

    protected $postData;

    public function __construct($postData)
    {
        $this->postData = $postData;
    }

    public function isType($type = self::TYPE_TEXT)
    {
        return $this->postData->MsgType == $type;
    }

    public function isText()
    {
        return $this->isType(self::TYPE_TEXT);
    }

    public function isImage()
    {
        return $this->isType(self::TYPE_IMAGE);
    }

    public function getType()
    {
        return $this->postData->MsgType;
    }

    public function getFromUserName()
    {
        return $this->postData->FromUserName;
    }

    public function getToUserName()
    {
        return $this->postData->ToUserName;
    }

    public function getCreateTime()
    {
        return $this->postData->CreateTime;
    }

    public function getMsgId()
    {
        if($this->postData->MsgType != self::TYPE_EVENT) {
            return $this->postData->MsgId;
        }
    }

    public function getContent()
    {
        if($this->isType(self::TYPE_TEXT)) {
            return $this->postData->Content;
        }
    }

    public function getPicUrl()
    {
        if($this->isType(self::TYPE_IMAGE)) {
            return $this->postData->PicUrl;
        }
    }

    public function getLat()
    {
        if($this->isType(self::TYPE_LOCATION)) {
            return $this->postData->Location_X;
        }
    }

    public function getLon()
    {
        if($this->isType(self::TYPE_LOCATION)) {
            return $this->postData->Location_Y;
        }
    }

    public function getScale()
    {
        if($this->isType(self::TYPE_LOCATION)) {
            return $this->postData->Scale;
        }
    }

    public function getLabel()
    {
        if($this->isType(self::TYPE_LOCATION)) {
            return $this->postData->Label;
        }
    }

    public function getTitle()
    {
        if($this->isType(self::TYPE_LINK)) {
            return $this->postData->Title;
        }
    }

    public function getDescription()
    {
        if($this->isType(self::TYPE_LINK)) {
            return $this->postData->Description;
        }
    }

    public function getUrl()
    {
        if($this->isType(self::TYPE_LINK)) {
            return $this->postData->Url;
        }
    }

    public function getEvent()
    {
        if($this->isType(self::TYPE_EVENT)) {
            return $this->postData->Event;
        }
    }

    public function getEventKey()
    {
        if($this->isType(self::TYPE_EVENT)) {
            return $this->postData->EventKey;
        }
    }
}
