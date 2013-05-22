<?php
namespace BqWechatSdk\Event;

class Result
{
    protected $output;

    public function __construct($output)
    {
        $this->output = $output;
    }

    public function output()
    {
        return $this->output;
    }
}
