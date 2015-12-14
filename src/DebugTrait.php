<?php

trait DebugTrait
{
    private function debug($value)
    {
        if(defined('DEBUG') && DEBUG)
        {
            var_dump($value);
        }
    }
}