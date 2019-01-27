<?php
/**
 * Created by PhpStorm.
 * User: Dh106
 * Date: 2019/1/26
 * Time: 14:04
 */

namespace dhsms\Send;


use dhsms\Send\Exceptions\InvalidArgumentException;
use dhsms\Send\Support\Config;

class Send
{
    /**
     * @var Config
     */
    private $config;


    /**
     * @var string
     */
    private $drivers;


    /**
     * @var
     */
    private $pool;


    /**
     * Send constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * 选择发送驱动
     * @param $driver
     * @return $this
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:26
     */
    public function driver($driver)
    {
        if (is_null($this->config->get($driver))) {
            throw new InvalidArgumentException("Driver [$driver]'s Config is not defined.");
        }

        $this->drivers = $driver;

        return $this;
    }

    /**
     * 建立连接池
     * @param $pool
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:28
     */
    public function pool($pool)
    {
        if (!isset($this->drivers)) {
            throw new InvalidArgumentException('Driver is not defined.');
        }

        $this->pool = $this->createPool($pool);

        return $this->pool;
    }

    /**
     * @param $pool
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:30
     */
    protected function createPool($pool)
    {
        if (!file_exists(__DIR__.'/Smspool/'.ucfirst($this->drivers).'/'.ucfirst($pool).'Pool.php')) {
            throw new InvalidArgumentException("Pool [$pool] is not supported.");
        }

        $pool = __NAMESPACE__.'\\Smspool\\'.ucfirst($this->drivers).'\\'.ucfirst($pool).'Pool';

        return $this->build($pool);
    }

    /**
     * 建立发送短信的驱动池
     * @param $pool
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:31
     */
    protected function build($pool)
    {
        return $pool($this->config->get($this->drivers));
    }
}