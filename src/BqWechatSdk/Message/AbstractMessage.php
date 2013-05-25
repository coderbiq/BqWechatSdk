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
        $this->postData = $xml;
        return $this;
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

    public function getFuncFlag()
    {
        $value = null;
        if(isset($this->data['func_flag'])) {
            $value = $this->data['func_flag'];
        }

        return $value;
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
