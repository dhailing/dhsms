<?php
/**
 * Created by Dh106
 * User: DH
 * Email: 206989662@qq.com
 * Date: 2019/7/17
 * Time: 15:00
 */

namespace dhsms\Send\Gateways\Juzhixin;


class ActionGateway extends Juzhixin
{

    public function send(array $config_biz)
    {
        parent::send($config_biz); // TODO: Change the autogenerated stub

        return $this->doSend();
    }
}
