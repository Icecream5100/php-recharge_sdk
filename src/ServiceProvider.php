<?php

namespace Ice\Recharge;

use Ice\Recharge\OFei\OFei;
use Ice\Recharge\Wzh\Wzh;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $apps = [
            'oFei' => OFei::class,
            'wzh' => Wzh::class,
        ];
        foreach ($apps as $name => $class) {
            $this->app->singleton(
                $class,
                function () use ($class, $name) {
                    return new $class(config('recharge.' . $name));
                }
            );
            $this->app->alias($class, 'recharge.' . $name);
        }
    }


    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/config.php' => config_path('recharge.php'),
            ]
        );
    }
}
