<?php

namespace MacauSE\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MacauSEUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
