<?php
/**
 * Created by PhpStorm.
 * User: Dh106
 * Date: 2019/1/26
 * Time: 14:04
 */

namespace dhsms\Send;


class Send
{
    private $config;


    private $drivers;


    private $pool;



    public function __construct(array $config)
    {
        $this->config = $config;
    }
}