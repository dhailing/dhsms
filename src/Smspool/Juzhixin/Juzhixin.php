<?php
/**
 * Created by PhpStorm.
 * User: Dh106
 * Date: 2019/1/27
 * Time: 10:23
 */

namespace dhsms\Send\Smspool\Juzhixin;


use dhsms\Send\Contracts\PoolInterface;
use dhsms\Send\Exceptions\InvalidArgumentException;
use dhsms\Send\Exceptions\PoolException;
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
            'password' => $this->parmas_conf->get('password', 'test'),
            'subid' => $this->parmas_conf->get('subid', '12'),
            'timestamp' => $this->timestamp,
            'sign' => $this->createSign(),
            'mobile' => $this->parmas_conf->get('mobile', ''),
            'content' => $this->parmas_conf->get('content', '123456'),
            'sendTime' => $this->parmas_conf->get('sendTime', ''),
            'extno' => $this->parmas_conf->get('extno', ''),
            'statusNum' => $this->parmas_conf->get('statusNum', ''),
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

    /**
     * 发送
     * @param array $config
     * @return array|mixed
     * @throws PoolException
     * User: Dh106
     * Date: 2019/1/27
     * Time: 19:46
     */
    public function send(array $config)
    {
        // TODO: Implement send() method.
        $postString = $this->formateData('send');

        return $this->getResult('send', $this->snd, $postString);
    }

    /**
     * 查询
     * @param array $config
     * @return array|mixed
     * @throws PoolException
     * User: Dh106
     * Date: 2019/1/27
     * Time: 19:46
     */
//    public function query(array $config)
//    {
//        // TODO: Implement query() method.
//        $postString = $this->formateData('query');
//
//        return $this->getResult('query', $this->overage, $postString);
//    }

    /**
     * 禁用关键字
     * @param array $config
     * @return array|mixed
     * @throws PoolException
     * User: Dh106
     * Date: 2019/1/27
     * Time: 19:46
     */
//    public function forbid(array $config)
//    {
//        // TODO: Implement forbid() method.
//        $postString = $this->formateData('forbid');
//
//        return $this->getResult('forbid', $this->checkkeyword, $postString);
//    }

    /**
     * 状态
     * @param array $config
     * @return array|mixed
     * @throws PoolException
     * User: Dh106
     * Date: 2019/1/27
     * Time: 19:47
     */
//    public function status(array $config)
//    {
//        // TODO: Implement status() method.
//        $postString = $this->formateData('status');
//
//        return $this->getResult('status', $this->statusnum, $postString);
//    }

    /**
     * 上行
     * @param array $config
     * @return array|mixed
     * @throws PoolException
     * User: Dh106
     * Date: 2019/1/27
     * Time: 19:47
     */
//    public function upward(array $config)
//    {
//        // TODO: Implement upward() method.
//        $postString = $this->formateData('upward');
//
//        return $this->getResult('upward', $this->upstream, $postString);
//    }


    /**
     * 格式化接口需要的数据
     * @param $type
     * @return bool|string
     * User: Dh106
     * Date: 2019/1/27
     * Time: 19:40
     */
    private function formateData($type)
    {
        $postData = [];
        switch ($type) {
            case 'send':
                $postData = [
                    'userid' => $this->config['subid'],
                    'timestamp' => $this->config['timestamp'],
                    'sign' => $this->config['sign'],
                    'mobile' => $this->config['mobile'],
                    'content' => $this->config['content'],
                    'sendTime' => $this->config['sendTime'],
                    'extno' => $this->config['extno'],
                ];
                break;
//            case 'query':
//                $postData = [
//                    'userid' => $this->config['subid'],
//                    'timestamp' => $this->config['timestamp'],
//                    'sign' => $this->config['sign'],
//                ];
//                break;
//            case 'forbid':
//                $postData = [
//                    'userid' => $this->config['subid'],
//                    'timestamp' => $this->config['timestamp'],
//                    'content' => $this->config['content'],
//                ];
//                break;
//            case 'status':
//                $postData = [
//                    'userid' => $this->config['subid'],
//                    'timestamp' => $this->config['timestamp'],
//                    'statusNum' => $this->config['statusNum'],
//                ];
//                break;
//            case 'upward':
//                $postData = [
//                    'userid' => $this->config['subid'],
//                    'timestamp' => $this->config['timestamp'],
//                    'sign' => $this->config['sign'],
//                ];
//                break;
//            case 'repassword':
//                break;
            default:
                break;
        }

        $formatString = '';
        foreach ($postData as $k => $v) {
            $formatString .= "$k=" . urlencode($v) . '&';
        }

        $postString = substr($formatString, 0, -1);

        return $postString;
    }


    /**
     * 返回结果
     * @param $type
     * @param $hotPath
     * @param $postSting
     * @return array
     * @throws PoolException
     * User: Dh106
     * Date: 2019/1/27
     * Time: 19:35
     */
    protected function getResult($type, $hotPath, $postSting)
    {

        $data = $this->fromXml($this->post($this->pool . $hotPath, $postSting));

        $result = [];
        try {
            switch ($type) {
                case 'send':
                    if ($data['returnstatus'] == 'Success') {
                        $result = [
                            'status' => $data['returnstatus'],
                            'msg' => $data['message'],
                            'data' => $data['taskID']
                        ];
                    } else {
                        throw new PoolException($data['message']);
                    }
                    break;
//                case 'query':
//                    if ($data['returnstatus'] == 'Sucess') {
//                        $result = [
//                            'status' => $data['returnstatus'],
//                            'msg' => $data['message'],
//                            'data' => $data['overage']
//                        ];
//                    } else {
//                        throw new PoolException($data['message']);
//                    }
//                    break;
//                case 'forbid':
//                    $result = [
//                        'status' => true,
//                        'msg' => $data['message'],
//                        'data' => null
//                    ];
//                    break;
//                case 'status':
//                    if (!isset($data['errorstatus'])) {
//                        $result = [
//                            'status' => true,
//                            'msg' => 'Success',
//                            'data' => $data
//                        ];
//                    } else {
//                        throw new PoolException($data['remark']);
//                    }
//                    break;
//                case 'upward':
//                    if (!isset($data['errorstatus'])) {
//                        $result = [
//                            'status' => true,
//                            'msg' => 'Success',
//                            'data' => $data
//                        ];
//                    } else {
//                        throw new PoolException($data['remark']);
//                    }
//                    break;
//                case 'repassword':
//
//                    break;
                default:
                    break;
            }

            return $result;
        } catch (PoolException $e) {
            throw new PoolException($e->getMessage(), 2000, $data);
        }
    }

    /**
     * 转义xml
     * @param $xml
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 17:44
     */
    protected function fromXml($xml)
    {
        if (!$xml) {
            throw new InvalidArgumentException('convert to array error !invalid xml');
        }

        libxml_disable_entity_loader(true);

        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA), JSON_UNESCAPED_UNICODE), true);
    }
}