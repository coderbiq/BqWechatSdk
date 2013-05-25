<?php
namespace BqWechatSdk\Message;

use BqWechatSdk\Message;

class Music extends AbstractMessage
{
    public function getType()
    {
        return Message::TYPE_MUSIC;
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


    public function toXmlString()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%d</CreateTime>
                <MsgType><![CDATA[music]]></MsgType>
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
            $this->getMusicTitle(),
            $this->getMusicDescription(),
            $this->getMusicUrl(),
            $this->getHQMusicUrl(),
            $this->getFuncFlag()
        );
    }

}
