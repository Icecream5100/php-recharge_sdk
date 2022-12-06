<?php

namespace Ice\Recharge\Wzh\Goods;

use Ice\Recharge\Core\WzhHttpCall;
use Ice\Recharge\RechargeConfig;
use Ice\Recharge\Core\OFeiHttpCall;

class Goods
{

    /**
     * @param int $pageNo 页码
     * @param int $pageSize 数量
     * @param null $productType （HF:话费、KQ：卡券、SW：实物、ZC： 直充、YK:油卡）
     * @param null $productName 商品名称 模糊查询
     * @return mixed
     * 商品列表
     */
    public function productList(
        int $pageNo,
        int $pageSize,
        $productType = null,
        $productName = null
    ) {
        $params["pageNo"] = $pageNo;
        $params["pageSize"] = $pageSize;
        if($productName){
            $params["productName"] = $productName;
        }
        if($productType){
            $params["productType"] = $productType;
        }
        return WzhHttpCall::gI()->call("api/product/list", $params);
    }


}
