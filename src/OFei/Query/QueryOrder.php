<?php

namespace Ice\Recharge\OFei\Query;

use Ice\Recharge\Core\OFeiHttpCall;

class QueryOrder
{

    /**
     * @param $game_userid
     * @param int $chargeType
     * @return mixed
     * 包体=userid+userpws+game_userid
     * 查询加油卡信息
     */
    public function queryCardInfo($game_userid, int $chargeType = 1)
    {
        $params["game_userid"] = $game_userid;
        $params = OFeiHttpCall::gI()->getParams($params);
        $params["chargeType"] = $chargeType;
        return OFeiHttpCall::gI()->call("sinopec/queryCardInfo.do", $params);
    }

    /**
     * @param string $sporder_id 商户订单号
     * @return mixed
     * 包体=userid+userpws+sporder_id
     * 查询订单详情
     */
    public function queryOrderInfo(string $sporder_id)
    {
        $params["sporder_id"] = $sporder_id;
        $params = OFeiHttpCall::gI()->getParams($params);
        return OFeiHttpCall::gI()->call("queryOrderInfo.do", $params);
    }

    /**
     * @param string $spbillid sp商户订单号
     * @return mixed
     * 包体=userid+userpws+sporder_id
     * 根据外部订单号查询订单充值状态
     * 返回0、1、9、-1  0 表示充值中，充值中的订单需要等待结果。9 充值失败，可以给客户退款。1 充值成功。-1 表示查不到此订单，此时不能作为失败处理该订单，需要联系欧飞人工核实。
     */
    public function query(string $spbillid)
    {
        $params["spbillid"] = $spbillid;
        $params = OFeiHttpCall::gI()->getParams($params);
        return OFeiHttpCall::gI()->call("api/query.do", $params);
    }
}
