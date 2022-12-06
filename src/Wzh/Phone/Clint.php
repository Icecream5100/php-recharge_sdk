<?php

namespace Ice\Recharge\Wzh\Phone;

use Ice\Recharge\Constants\OilConstant;
use Ice\Recharge\Core\WzhHttpCall;
use Ice\Recharge\RechargeConfig;

class Clint
{

    /**
     * @param string $order_no 订单号
     * @param int $amount 订单金额 元做单位
     * @param string $mobileNo 手机号码
     * @param null $ret_url 回调地址
     * @return mixed
     * 充值话费
     */
    public function mobileHf(
        string $order_no,
        int $amount,
        string $mobileNo,
        $ret_url = null
    ) {
        $params["serialNo"] = $order_no;
        $goodsId = RechargeConfig::gI()->getWzhConfig()->get("product")[OilConstant::WZH_HUA_FA][$amount] ?? null;
        $params["goodsId"] = $goodsId;
        $params["mobileNo"] = $mobileNo;
        $params["chargeType"] = 1;
        $params["volume"] = $amount;
        $params["callbackUrl"] = $ret_url;
        return WzhHttpCall::gI()->call("api/order/recharge/mobile/hf", $params);
    }

}
