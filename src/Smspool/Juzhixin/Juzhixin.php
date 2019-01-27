<?php
/**
 * Created by PhpStorm.
 * User: Dh106
 * Date: 2019/1/27
 * Time: 10:23
 */

namespace dhsms\Send\Smspool;


use dhsms\Send\Contracts\PoolInterface;
use dhsms\Send\Support\Config;
use dhsms\Send\Traits\HasHttpRequest;

abstract class Juzhixin implements PoolInterface
{
    use HasHttpRequest;

    protected $pool = 'http://39.107.112.10:8088';

    /**
     * 发送
     * @var string
     */
    protected $snd = '/v2sms.aspx?action=send';

    /**
     * 余额及已发送量查询
     * @var string
     */
    protected $overage = '/v2sms.aspx?action=overage';

    /**
     * 非法关键字
     * @var string
     */
    protected $checkkeyword = '/v2sms.aspx?action=checkkeyword';

    /**
     * 状态报告
     * @var string
     */
    protected $statusnum = '/v2statusApi.aspx?action=query';

    /**
     * 上行
     * @var string
     */
    protected $upstream = '/v2callApi.aspx?action=query';

    /**
     * 自带配置
     * @var array
     */
    protected $config;

    /**
     * 用户配置参数
     * @var Config
     */
    protected $parmas_conf;


    protected $timestamp;

    public function __construct(array $config)
    {
        $this->parmas_conf = new Config($config);

        $this->timestamp = date('Ymdhis');

        $this->config = [
            'account' => $this->parmas_conf->get('account', 'test'),
            'password' => $this->parmas_conf->get('password', '111111'),
            'subid' => $this->parmas_conf->get('subid', ''),
            'timestamp' => $this->timestamp,
            'sign' => $this->createSign(),
            'mobile' => $this->parmas_conf->get('mobile', ''),
            'content' => $this->parmas_conf->get('content', '123456'),
            'sendTime' => $this->parmas_conf->get('sendTime', ''),
            'extno' => $this->parmas_conf->get('extno', ''),
        ];
    }


    /**
     * 签名
     * @return string
     * User: Dh106
     * Date: 2019/1/27
     * Time: 14:31
     */
    private function createSign()
    {
        $account = $this->parmas_conf->get('account');
        $password = $this->parmas_conf->get('password');

        return md5($account . $password . $this->timestamp);
    }

    public function send(array $config)
    {
        // TODO: Implement send() method.
    }

    public function query(array $config)
    {
        // TODO: Implement query() method.
    }

    public function forbid(array $config)
    {
        // TODO: Implement forbid() method.
    }

    public function status(array $config)
    {
        // TODO: Implement status() method.
    }

    public function upward(array $config)
    {
        // TODO: Implement upward() method.
    }

    public function repassword(array $config)
    {
        // TODO: Implement repassword() method.
    }
}