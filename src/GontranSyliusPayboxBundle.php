<?php

namespace Gontran\SyliusPayboxBundle;

use Gontran\SyliusPayboxBundle\DependencyInjection\GontranSyliusPayboxExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class GontranSyliusPayboxBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new GontranSyliusPayboxExtension();
        }

        return $this->extension;
    }
}
