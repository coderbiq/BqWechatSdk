<?php
namespace BqWechatSdk\Event;

use BqWechatSdk\Message;

class Result
{
    protected $output;
    protected $message;

    public function __construct($output = null)
    {
        $this->output = $output;
    }

    public function setMessage(Message $message)
    {
        $this->message = $message;
    }

    public function output()
    {
        if($this->message !== null) {
            return $this->message->toXml();
        } else {
            return $this->output;
        }
    }
}
