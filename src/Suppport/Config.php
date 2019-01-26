<?php

namespace dhsms\Send\Support;

use ArrayAccess;
use dhsms\Send\Exceptions\InvalidArgumentException;

class Config implements ArrayAccess
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Config constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param null $key
     * @param null $default
     * @return array|mixed|null
     * User: Dh106
     * Date: 2019/1/26
     * Time: 17:47
     */
    public function get($key = null, $default = null)
    {
        $config = $this->config;

        if (is_null($key)) {
            return $config;
        }

        if (isset($config[$key])) {
            return $config[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($config) || !array_key_exists($segment, $config)) {
                return $default;
            }
            $config = $config[$segment];
        }

        return $config;
    }

    /**
     * @param string $key
     * @param $value
     * @return array
     * User: Dh106
     * Date: 2019/1/26
     * Time: 17:48
     */
    public function set(string $key, $value)
    {
        if ($key == '') {
            throw new InvalidArgumentException('Invalid config key.');
        }

        // 只支持三维数组，多余无意义
        $keys = explode('.', $key);
        switch (count($keys)) {
            case 1:
                $this->config[$key] = $value;
                break;
            case 2:
                $this->config[$keys[0]][$keys[1]] = $value;
                break;
            case 3:
                $this->config[$keys[0]][$keys[1]][$keys[2]] = $value;
                break;

            default:
                throw new InvalidArgumentException('Invalid config key.');
        }

        return $this->config;
    }

    /**
     * @param mixed $offset
     * @return bool
     * User: Dh106
     * Date: 2019/1/26
     * Time: 18:00
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->config);
    }

    /**
     * @param mixed $offset
     * @return array|mixed|null
     * User: Dh106
     * Date: 2019/1/26
     * Time: 18:00
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * User: Dh106
     * Date: 2019/1/26
     * Time: 18:00
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     * User: Dh106
     * Date: 2019/1/26
     * Time: 18:00
     */
    public function offsetUnset($offset)
    {
        $this->set($offset, null);
    }
}
