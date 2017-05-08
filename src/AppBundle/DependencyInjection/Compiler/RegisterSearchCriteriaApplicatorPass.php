<?php

declare(strict_types=1);

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterSearchCriteriaApplicatorPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('app.search.elastic_engine')) {
            return;
        }

        foreach ($container->findTaggedServiceIds('search_criteria_applicator') as $taggedServiceId => $taggedServiceConfig) {
            $engineDefinition = $container->getDefinition('app.search.elastic_engine');
            $engineDefinition->addMethodCall('addSearchCriteriaApplicator', [new Reference($taggedServiceId)]);
        }
    }
}
