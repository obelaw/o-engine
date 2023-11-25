<?php

namespace Obelaw\Traits;

use Obelaw\Facades\Bundles;

trait ObelawRegisterProvoiders
{
    protected function registerProvoiders()
    {
        try {
            if ($providers = Bundles::getProviders()) {
                foreach ($providers as $provider) {
                    $this->app->register($provider);
                }
             }
        } catch (\Throwable $th) {
            if (!$this->app->runningInConsole()) {
                throw $th;
            }
        }
    }
}
