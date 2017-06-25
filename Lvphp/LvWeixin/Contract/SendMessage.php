<?php

namespace Lvphp\LvWeixin\Contract;

interface SendMessage extends Message
{
    /**
     * @return array
     */
    public function jsonData();
}