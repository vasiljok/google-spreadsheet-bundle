<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
    /**
     * @return array
     */
    public function registerBundles()
    {
        $bundles = array(
            // Dependencies
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            new Wk\GoogleSpreadsheetBundle\WkGoogleSpreadsheetBundle(),
        );

        return $bundles;
    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
    }
}

