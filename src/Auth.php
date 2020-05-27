<?php
namespace weetoolAuth;

use weetoolAuth\Exception\AuthException;

class Auth
{
    public $url = '';
    public $apiId = '';
    public $apiKey = '';

    /**
     * Auth constructor.
     * @param string $apiId
     * @param string $apiKey
     * @param string $url
     */
    public function __construct($apiId, $apiKey, $url)
    {
        $this->url = $url;
        $this->apiId = $apiId;
        $this->apiKey = $apiKey;
    }


    /**
     * 传入token来判断该用户是否有效，返回一个数组，如果数组status为0表示该用户不合法或者余额不够，status为1表示该用户合法
     * @param string $token
     * @return array|mixed
     */
    public function auth($token)
    {
        if(empty($this->url))
            throw new AuthException("url can not be empty");

        try
        {
            $tool = new HttpTools();
            $tool->url = $this->url;

            $rs = $tool->get(array(
                'id' => $this->apiId,
                'token' => $token,
                'sign' => md5($token . $this->apiKey)
            ));

            $arr = json_decode($rs, true);

            if (is_null($arr))
            {
                return array('status' => 0);
            }

            return $arr;
        }
        catch(\Exception $e)
        {
            throw new AuthException();
        }
    }


    /**
     * 参数aid为调用auth()方法返回的数组中的aid
     * 判断该用户调用该api的次数，返回的数组中count字段表示调用次数，expire表示调用过期时间，请根据自己的收费模式进行选择
     * @param string $aid
     * @return array|null
     */
    public function getCount($aid)
    {
        if(empty($this->url))
            throw new AuthException("url can not be empty");

        $tool = new HttpTools();

        $tool->url = $this->url . '/available';

        $rs = $tool->get(array(
            'id' => $this->apiId,
            'aid' => $aid,
            'sign' => md5($aid . $this->apiKey)
        ));

        $arr = json_decode($rs, true);

        if (is_null($arr))
        {
            return null;
        }

        return $arr;
    }

    /**
     *
     * 参数aid为调用auth()方法返回的数组中的aid
     * 扣费回调方法，返回值如果status为1表示扣费成功
     *
     * @param $aid
     * @return mixed
     */
    public function done($aid)
    {
        if(empty($this->url))
            throw new AuthException("url can not be empty");

        $tool = new HttpTools();

        $tool->url = $this->url . '/auth/done';

        $rs = $tool->get(array(
            'id' => $this->apiId,
            'aid' => $aid,
            'sign' => md5($aid . $this->apiKey)
        ));

        return json_decode($rs, true);
    }
}