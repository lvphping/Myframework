<?php

namespace Lvphp\LvWeixin\Message;

use Lvphp\LvWeixin\Contract\ReplyMessage;

class Raw implements ReplyMessage
{
    public $data;

    /**
     * 手动构建xml字符串
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function xmlData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function type()
    {
        return 'raw';
    }
}