<?php
namespace weetoolAuth;


use weetoolAuth\Exception\NetException;

class HttpTools
{
    public $url;
    public $timeout;

    private $ch;

    public function __construct($timeout = 3)
    {
        $this->ch = curl_init();
        $this->timeout = $timeout;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function get($data = array())
    {
        try
        {
            $ch = $this->ch;

            if(empty($data))
                curl_setopt($ch, CURLOPT_URL, $this->url);
            else
                curl_setopt($ch, CURLOPT_URL, $this->url . '?' . http_build_query($data));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_HEADER, 0);

            curl_setopt($ch, CURLOPT_POST, 0);

//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

            curl_setopt($ch, CURLOPT_ENCODING, "gzip");

            return curl_exec($ch);
        }
        catch (\Exception $exception)
        {
            print_r($exception);
            return null;
        }
    }

    /**
     * @param array $postData
     * @return string|null
     */
    public function post($postData = array())
    {
        try
        {
            $ch = $this->ch;
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_HEADER, 0);

            curl_setopt($ch, CURLOPT_POST, 1);


            if(!empty($postData))
                curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($postData) ? http_build_query($postData) : $postData);


//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

            curl_setopt($ch, CURLOPT_ENCODING, "gzip");

            return curl_exec($ch);
        }
        catch (\Exception $exception)
        {
            return null;
        }
    }

    public function getError()
    {
        return curl_error($this->ch);
    }

    public function close()
    {
        \curl_close($this->ch);
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->close();
    }
}