<?php

namespace Fenrizbes\UploadableBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FenrizbesUploadableExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['root_path']) && !empty($config['root_path'])) {
            $root_path = rtrim($config['root_path'], '/');
        } else {
            $root_path = $container->getParameter('kernel.root_dir') .'/../web';
        }

        $container->setParameter('fenrizbes_uploadable.root_path', $root_path);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->registerResources($container);
    }

    protected function registerResources(ContainerBuilder $container)
    {
        $templatingEngines = $container->getParameter('templating.engines');

        if (in_array('twig', $templatingEngines)) {
            $container->setParameter('twig.form.resources', array_merge(
                array('FenrizbesUploadableBundle:Form:fields.html.twig'),
                $container->getParameter('twig.form.resources')
            ));
        }
    }
}
