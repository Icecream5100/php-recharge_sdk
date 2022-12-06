<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Ice\Recharge;

use Ice\Recharge\Constants\ConfigTypeConstant;
use Ice\Tool\Support\Collection;
use Ice\Tool\Di;
use Ice\Tool\Singleton;

class RechargeConfig extends Collection
{
    use Singleton;


    /**
     * @return RechargeConfig|callable
     */
    public function getOFeiConfig()
    {
        return Di::gI()->get(ConfigTypeConstant::OFEI_CONFIG_NAME);
    }

    /**
     * @return RechargeConfig|callable
     */
    public function getWzhConfig()
    {
        return Di::gI()->get(ConfigTypeConstant::WZH_CONFIG_NAME);
    }
}
