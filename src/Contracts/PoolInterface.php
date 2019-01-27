<?php
/**
 * Created by PhpStorm.
 * User: Dh106
 * Date: 2019/1/27
 * Time: 10:14
 */

namespace dhsms\Send\Contracts;


interface PoolInterface
{
    /**
     * 发送
     * @param array $config
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:16
     */
    public function send(array $config);

    /**
     * 查询
     * @param array $config
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:18
     */
    public function query(array $config);

    /**
     * 非法词查询
     * @param array $config
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:19
     */
    public function forbid(array $config);

    /**
     * 状态报告
     * @param array $config
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:20
     */
    public function status(array $config);


    /**
     * 上行查询
     * @param array $config
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:21
     */
    public function upward(array $config);

    /**
     * 修改密码
     * @param array $config
     * @return mixed
     * User: Dh106
     * Date: 2019/1/27
     * Time: 10:21
     */
    public function repassword(array $config);
}