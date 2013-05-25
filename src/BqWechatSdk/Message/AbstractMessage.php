<?php
namespace BqWechatSdk\Message;

use SimpleXMLElement;

abstract class AbstractMessage implements MessageInterface
{
    protected $data;
    protected $postData;

    public function exchangeArray(Array $array)
    {
        $this->data = $array;
        return $this;
    }

    public function exchangeXml(SimpleXMLElement $xml)
    {
        $this
            ->setFromUserName($xml->FromUserName)
            ->setToUserName($xml->ToUserName)
            ->setCreateTime($xml->CreateTime);
        return $this;
    }

    public function getFromUserName()
    {
        return $this->getData('from_user_name');
    }

    public function getToUserName()
    {
        return $this->getData('to_user_name');
    }

    public function getCreateTime()
    {
        return $this->getData('create_time');
    }

    public function getFuncFlag()
    {
        return $this->getData('func_flag');
    }

    public function setFromUserName($fromUserName)
    {
        return $this->setData('from_user_name', $fromUserName);
    }

    public function setToUserName($toUserName)
    {
        return $this->setData('to_user_name', $toUserName);
    }

    public function setCreateTime($createTime)
    {
        return $this->setData('create_time', $createTime);
    }

    public function setFuncFlag($funcFlag)
    {
        return $this->setData('func_flag', $funcFlag);
    }

    protected function getData($name)
    {
        $value = null;

        if(isset($this->data[$name])) {
            $value = $this->data[$name];
        }

        return $value;
    }

    protected function setData($name, $value)
    {
        $this->data[$name] = $value;
        return $this;
    }
}
