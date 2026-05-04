<?php

namespace App\Traits;

use Lab404\Impersonate\Services\ImpersonateManager;

trait Impersonatable
{
    /**
     * Leave the current impersonation.
     *
     * @param void
     * @return  bool
     */
    public function impersonator()
    {
		if ($this->isImpersonated()) {
        	return app(ImpersonateManager::class)->getImpersonator();
		}

		return null;
    }
}

