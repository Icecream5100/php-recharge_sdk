<?php

namespace Ice\Recharge\OFei\OFrecharge;

use Ice\Recharge\RechargeConfig;
use Ice\Recharge\Core\OFeiHttpCall;

class Recharge
{

    /**
     * @param string $order_no 订单号
     * @param int $amount 订单金额 元做单位
     * @param string $game_userid 油卡卡号
     * @param null $ret_url 回调地址
     * @param int $chargeType 充值类型
     * @return mixed
     * 包体=userid+userpws+cardid+cardnum+sporder_id+sporder_time+ game_userid
     * 查询加油卡信息
     */
    public function onlineOrder(
        string $order_no,
        int $amount,
        string $game_userid,
        $ret_url = null,
        int $chargeType = 1
    ) {
        $carId = RechargeConfig::gI()->getOFeiConfig()->get("product")[$chargeType][$amount] ?? null;
        $params["cardid"] = $carId;
        $params["cardnum"] = 1;
        $params["sporder_id"] = $order_no;
        $params["sporder_time"] = date("YmdHis");
        $params["game_userid"] = $game_userid;
        $params = OFeiHttpCall::gI()->getParams($params);
        $params["chargeType"] = $chargeType;
//        $params["gasCardTel"] = $chargeType;
        $params["ret_url"] = $ret_url;
        return OFeiHttpCall::gI()->call("sinopec/onlineorder.do", $params);
    }


    /**
     * @param string $order_no 订单号
     * @param string $carId 商品编号
     * @param int $buyNum 购买数量
     * @param string $customerNo 充值账户
     * @param null $ret_url 回调地址
     * @param null $memberId C端用户唯一标识
     * @param null $extendParams 根据实际需要传值，值encodeUrlGBK传入 例如微信立减金传参样例
     * @return mixed
     * 包体=userId+userPws+cardId+buyNum+spOrderId+orderTime+customerNo
     * 查询加油卡信息
     */
    public function newOnlineOrder(
        string $order_no,
        string $carId,
        int $buyNum,
        string $customerNo,
        $ret_url = null,
        $memberId = null,
        $extendParams = null
    ) {
        $params["cardId"] = $carId;
        $params["buyNum"] = $buyNum;
        $params["spOrderId"] = $order_no;
        $params["orderTime"] = date("YmdHis");
        $params["customerNo"] = $customerNo;
        $params = OFeiHttpCall::gI()->getParamsTuo($params);
        $params["retUrl"] = $ret_url;
        $params["memberId"] = $memberId;
        $params["extendParams"] = $extendParams;
        return OFeiHttpCall::gI()->call("newOnlineOrder.do", $params);
    }


}
