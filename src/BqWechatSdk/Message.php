<?php
namespace BqWechatSdk;

class Message
{
    const TYPE_TEXT              = 'text';
    const TYPE_IMAGE             = 'image';
    const TYPE_LOCATION          = 'location';
    const TYPE_LINK              = 'link';
    const TYPE_EVENT             = 'event';
    const TYPE_MUSIC             = 'music';
    const TYPE_NEWS              = 'news';
    const EVENT_TYPE_SUBSCRIBE   = 'subscribe';
    const EVENT_TYPE_UNSUBSCRIBE = 'unsubscribe';
    const EVENT_TYPE_CLICK       = 'CLICK';

    protected $postData;
    protected $data;
    protected $newsItem = array();

    public function __construct($postData = null)
    {
        $this->postData = $postData;
    }

    public function addNewsItem($title, $description, $picUrl, $url)
    {
        $this->newsItem[] = array(
            'title'       => $title,
            'description' => $description,
            'pic_url'     => $picUrl,
            'url'         => $url
        );

        return $this;
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

    public function getMusicUrl()
    {
        return $this->getData('music_url');
    }

    public function getHQMusicUrl()
    {
        return $this->getData('hq_music_url');
    }

    public function getMusicTitle()
    {
        return $this->getData('music_title');
    }

    public function getMusicDescription()
    {
        return $this->getData('music_description');
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

    public function setMusicUrl($url)
    {
        $this->data['music_url'] = $url;
        return $this;
    }

    public function setHQMusicUrl($url)
    {
        $this->data['hq_music_url'] = $url;
        return $this;
    }

    public function setMusicTitle($title)
    {
        $this->data['music_title'] = $title;
        return $this;
    }

    public function setMusicDescription($description)
    {
        $this->data['music_description'] = $description;
        return $this;
    }

    public function toXml()
    {
        switch($this->getType())
        {
        case self::TYPE_TEXT:
            return $this->toTextXml();
        case self::TYPE_MUSIC:
            return $this->toMusicXml();
        case self::TYPE_NEWS:
            return $this->toNewsXml();
        }
    }

    protected function toNewsXml()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%d</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <ArticleCount>%d</ArticleCount>
                <Articles>%s</Articles>
                <FuncFlag>%d</FuncFlag>
            </xml> 
            ";

        $itemXml = "
            <item>
                <Title><![CDATA[%s]]></Title> 
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
            </item>
            ";

        $itemArray = array();
        foreach($this->newsItem as $item) {
            $itemArray[] = sprintf(
                $itemXml,
                $item['title'],
                $item['description'],
                $item['pic_url'],
                $item['url']
            );
        }
        $itemString = implode($itemArray);

        return sprintf(
            $xml,
            $this->getToUserName(),
            $this->getFromUserName(),
            $this->getCreateTime(),
            $this->getType(),
            count($itemArray),
            $itemString,
            $this->getFuncFlag()
        );
    }

    protected function toTextXml()
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

    protected function toMusicXml()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%d</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Music>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <MusicUrl><![CDATA[%s]]></MusicUrl>
                    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                </Music>
                <FuncFlag>%d</FuncFlag>
            </xml>
            ";

        return sprintf(
            $xml,
            $this->getToUserName(),
            $this->getFromUserName(),
            $this->getCreateTime(),
            $this->getType(),
            $this->getMusicTitle(),
            $this->getMusicDescription(),
            $this->getMusicUrl(),
            $this->getHQMusicUrl(),
            $this->getFuncFlag()
        );
    }

    protected function getData($name, $postName = null)
    {
        $value = null;

        if(isset($this->data[$name])) {
            $value = $this->data[$name];
        } elseif( $this->postData !== null && $postName !== null) {
            $this->data[$name] = $this->postData->$postName;
            $value             = $this->data[$name];
        }

        return $value;
    }
}
