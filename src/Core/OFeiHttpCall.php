<?php

namespace Ice\Recharge\Core;

use Illuminate\Support\Facades\Http;
use Ice\Recharge\RechargeConfig;
use Ice\Tool\Singleton;
use Ice\Tool\Support\Log;

class OFeiHttpCall
{
    use Singleton;

    protected $config = [];


    public function __construct()
    {
        $config = RechargeConfig::gI()->getOFeiConfig();
        $this->config = $config;
    }

    public function call($action, array $params)
    {
        $params = array_merge(
            $params,
            [
                'version' => $this->config->get("version"),
            ]
        );

        $url = $this->config->get("host") . '/' . $action;
        $log = Log::gI("欧飞请求信息");
        $log->appendRequest($url, $params, "POST");
        $response = Http::asForm()->post($url, $params);
        $result = $response->body();


        if (strstr($result, "GBK")) {
            $result = iconv("GBK", "UTF-8", $result);
            $result = str_replace("GBK", "UTF-8", $result);
        }
        if (strstr($result, "GB2312")) {
            $result = iconv("GB2312", "UTF-8", $result);
            $result = str_replace("GB2312", "UTF-8", $result);
        }
        $xml_parser = xml_parser_create();
        if (!xml_parse($xml_parser, $result, true)) {
            xml_parser_free($xml_parser);
            $log->appendResponse($url, $result, $response->status());
            $log->save();
            return $result;
        }

        $result = json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $log->appendResponse($url, $result, $response->status());
        $log->save();
        return $result;
    }

    public function getParams($params): array
    {
        $arr = array_merge(
            [
                'userid' => $this->config->get("userId"),
                'userpws' => md5($this->config->get("userpwd")),
            ],
            $params
        );

        $arr["md5_str"] = strtoupper(md5(implode('', $arr) . $this->config->get("key")));
        return $arr;
    }


    public function getParamsTuo($params): array
    {
        $arr = array_merge(
            [
                'userId' => $this->config->get("userId"),
                'userPws' => md5($this->config->get("userpwd")),
            ],
            $params
        );

        $arr["md5Str"] = strtoupper(md5(implode('', $arr) . $this->config->get("key")));
        return $arr;
    }
}
