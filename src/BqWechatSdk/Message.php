<?php
namespace BqWechatSdk;

class Message
{
    const TYPE_TEXT              = 'text';
    const TYPE_IMAGE             = 'image';
    const TYPE_LOCATION          = 'location';
    const TYPE_LINK              = 'link';
    const TYPE_EVENT             = 'event';
    const EVENT_TYPE_SUBSCRIBE   = 'subscribe';
    const EVENT_TYPE_UNSUBSCRIBE = 'unsubscribe';
    const EVENT_TYPE_CLICK       = 'CLICK';

    protected $postData;
    protected $data;

    public function __construct($postData = null)
    {
        $this->postData = $postData;
    }

    public function isType($type = self::TYPE_TEXT)
    {
        return $this->getType() == $type;
    }

    public function isText()
    {
        return $this->isType(self::TYPE_TEXT);
    }

    public function isImage()
    {
        return $this->isType(self::TYPE_IMAGE);
    }

    public function isLocation()
    {
        return $this->isType(self::TYPE_LOCATION);
    }

    public function isLink()
    {
        return $this->isType(self::TYPE_LINK);
    }

    public function isEvent()
    {
        return $this->isType(self::TYPE_EVENT);
    }

    public function isSubscribeEvent()
    {
        $valid = false;
        if(
            $this->isEvent() 
            && $this->getEvent() == self::EVENT_TYPE_SUBSCRIBE) {
                $valid = true;
        }
        return $valid;
    }

    public function isUnsubscribeEvent()
    {
        $valid = false;
        if(
            $this->isEvent() 
            && $this->getEvent() == self::EVENT_TYPE_UNSUBSCRIBE) {
                $valid = true;
        }
        return $valid;
    }

    public function isClickEvent()
    {
        $valid = false;
        if(
            $this->isEvent() 
            && $this->getEvent() == self::EVENT_TYPE_CLICK) {
                $valid = true;
        }
        return $valid;
    }

    public function getType()
    {
        return $this->getData('type', 'MsgType');
    }

    public function getFromUserName()
    {
        return $this->getData('from_user_name', 'FromUserName');
    }

    public function getToUserName()
    {
        return $this->getData('to_user_name','ToUserName');
    }

    public function getCreateTime()
    {
        return $this->getData('create_time', 'CreateTime');
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
            return $this->getData('content', 'Content');
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

    public function getFuncFlag()
    {
        $value = null;
        if(isset($this->data['func_flag'])) {
            $value = $this->data['func_flag'];
        }

        return $value;
    }

    public function setType($type)
    {
        $this->data['type'] = $type;
        return $this;
    }

    public function setFromUserName($fromUserName)
    {
        $this->data['from_user_name'] = $fromUserName;
        return $this;
    }

    public function setToUserName($toUserName)
    {
        $this->data['to_user_name'] = $toUserName;
        return $this;
    }

    public function setContent($content)
    {
        $this->data['content'] = $content;
        return $this;
    }

    public function setCreateTime($createTime)
    {
        $this->data['create_time'] = $createTime;
        return $this;
    }

    public function setFuncFlag($funcFlag)
    {
        $this->data['func_flag'] = $funcFlag;
        return $this;
    }

    public function toXml()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%d</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>%d</FuncFlag>
            </xml>
            ";
        return sprintf(
            $xml, 
            $this->getToUserName(), 
            $this->getFromUserName(),
            $this->getCreateTime(),
            $this->getType(),
            $this->getContent(),
            $this->getFuncFlag()
        );
    }

    protected function getData($name, $postName)
    {
        $value = null;

        if(isset($this->data[$name])) {
            $value = $this->data[$name];
        } elseif( $this->postData !== null) {
            $this->data[$name] = $this->postData->$postName;
            $value             = $this->data[$name];
        }

        return $value;
    }
}
