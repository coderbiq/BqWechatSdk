<?php
namespace BqWechatSdk\Message;

use BqWechatSdk\Message;

class News extends AbstractMessage
{
    protected $newsItem = array();

    public function getType()
    {
        return Message::TYPE_NEWS;
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

    public function toXmlString()
    {
        $xml = "
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%d</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
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
            count($itemArray),
            $itemString,
            $this->getFuncFlag()
        );
    }

}
