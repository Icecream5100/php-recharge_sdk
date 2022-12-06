<?php

namespace Ice\Recharge\Wzh\Recharge;

use Ice\Recharge\Core\WzhHttpCall;
use Ice\Recharge\RechargeConfig;
use Ice\Recharge\Core\OFeiHttpCall;

class Recharge
{

    /**
     * @param string $order_no 订单号
     * @param int $amount 订单金额 元做单位
     * @param string $refuelAccount 油卡卡号
     * @param string $phone 持卡人手机号
     * @param null $ret_url 回调地址
     * @param int $chargeType 充值类型 1 中石油，2 中石化
     * @return mixed
     * 充值油卡
     */
    public function onlineOrder(
        string $order_no,
        int $amount,
        string $refuelAccount,
        string $phone,
        $ret_url = null,
        int $chargeType = 1
    ) {
        $params["serialNo"] = $order_no;
        $goodsId = RechargeConfig::gI()->getWzhConfig()->get("product")[$chargeType][$amount] ?? null;
        $params["goodsId"] = $goodsId;
        $params["callbackUrl"] = $ret_url;
        $params["chargeType"] = $chargeType;
        $params["refuelAccount"] = $refuelAccount;
        $params["refuelPhone"] = $phone;
        $params["volume"] = $amount;
//        $params["possessIdCard"] = $ret_url;
//        $params["possessUsername"] = $ret_url;
        $params["possessPhone"] = $phone;
        return WzhHttpCall::gI()->call("api/order/recharge/refuel", $params);
    }

}
