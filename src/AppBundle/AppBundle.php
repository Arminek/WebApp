<?php

namespace AppBundle;

use AppBundle\DependencyInjection\Compiler\RegisterSearchCriteriaApplicatorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AppBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterSearchCriteriaApplicatorPass());
    }
}
