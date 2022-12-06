<?php

namespace Ice\Recharge\OFei;


use Ice\Recharge\RechargeConfig;
use Ice\Recharge\Constants\ConfigTypeConstant;
use Ice\Tool\Di;


/**
 * Class OFei.
 *
 * @property \Ice\Recharge\OFei\Query\QueryOrder $query
 * @property \Ice\Recharge\OFei\OFrecharge\Recharge $recharge
 */
class OFei
{

    protected $providers = [
        'query' => Query\QueryOrder::class,
        'recharge' => OFrecharge\Recharge::class,
    ];

    public function __construct(array $config = [])
    {
        Di::gI()->set(ConfigTypeConstant::OFEI_CONFIG_NAME, new RechargeConfig($config ?? []));
        foreach ($this->providers as $key => $provider) {
            Di::gI()->set($key, new $provider());
            $this->$key = Di::gI()->get($key);
        }
    }

}
