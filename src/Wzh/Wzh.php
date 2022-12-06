<?php

namespace Ice\Recharge\Wzh;


use Ice\Recharge\RechargeConfig;
use Ice\Recharge\Constants\ConfigTypeConstant;
use Ice\Tool\Di;


/**
 * Class Wzh.
 *
 * @property \Ice\Recharge\Wzh\Goods\Goods $goods
 * @property \Ice\Recharge\Wzh\Recharge\Recharge $recharge
 * @property \Ice\Recharge\Wzh\Phone\Clint $phone
 */
class Wzh
{

    protected $providers = [
        'goods' => Goods\Goods::class,
        'recharge' => Recharge\Recharge::class,
        'phone' => Phone\Clint::class,
    ];

    public function __construct(array $config = [])
    {
        Di::gI()->set(ConfigTypeConstant::WZH_CONFIG_NAME, new RechargeConfig($config ?? []));
        foreach ($this->providers as $key => $provider) {
            Di::gI()->set($key, new $provider());
            $this->$key = Di::gI()->get($key);
        }
    }

}
