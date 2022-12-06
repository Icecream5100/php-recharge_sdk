<?php

namespace Ice\Recharge\Core;

use Illuminate\Support\Facades\Http;
use Ice\Recharge\RechargeConfig;
use Ice\Tool\Singleton;
use Ice\Tool\Support\Log;

class WzhHttpCall
{
    use Singleton;

    protected $config = [];


    public function __construct()
    {
        $config = RechargeConfig::gI()->getWzhConfig();
        $this->config = $config;
    }

    public function call($action, array $params)
    {
        $params = array_merge(
            $params,
            [
                'appId' => $this->config->get("appId"),
                'nonceStr' => md5("ydz".microtime(true). rand(1000000, 9999999)),
                'timestamp' => $this->microtime_float(),
            ]
        );

        $params["sign"] = $this->generate_sign($params, $this->config->get("appKey"));
        $url = $this->config->get("host") . '/' . $action;
        $log = Log::gI("万众惠请求信息");
        $log->appendRequest($url, $params, "POST");
        $response = Http::post($url, $params);
        $result = $response->body();
        $result = json_decode($result, true);
        $log->appendResponse($url, $result, $response->status());
        $log->save();
        return $result;
    }

    public function generate_sign(array $attributes, $key, $encryptMethod = 'md5')
    {
        ksort($attributes);

        $attributes['key'] = $key;
        return strtoupper(call_user_func_array($encryptMethod, [urldecode(http_build_query($attributes))]));
    }


    public function jsonPost($url, $postData, $DataType = "json")
    {
        $curl = curl_init(); // 启动一个CURL会话
        $postDataString = "";
        if ($DataType == "json") {
            $postDataString = json_encode($postData);;//格式化参数
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array('Content-Type: application/json', 'Content-Length: ' . strlen($postDataString))
            );
        } else {
            $postDataString = http_build_query($postData);//格式化参数
        }
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //从证书中检查SSL加密算法是否存在
        curl_setopt(
            $curl,
            CURLOPT_SSLVERSION,
            6
        ); //CURL_SSLVERSION_DEFAULT (0), CURL_SSLVERSION_TLSv1 (1), CURL_SSLVERSION_SSLv2 (2), CURL_SSLVERSION_SSLv3 (3), CURL_SSLVERSION_TLSv1_0 (4), CURL_SSLVERSION_TLSv1_1 (5)， CURL_SSLVERSION_TLSv1_2 (6) 中的其中一个。
        curl_setopt($curl, CURLOPT_POST, true); //发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataString); //Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); //设置超时限制防止死循环返回
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            $tmpInfo = curl_error($curl);//捕抓异常
        }
        curl_close($curl); //关闭CURL会话

        return $tmpInfo; //返回数据

    }


    public function microtime_float()
    {
        list($msec, $sec) = explode(" ", microtime());
        return $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }


}
