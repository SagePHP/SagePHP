<?php
namespace SagePHP;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Sage
{
    /**
     * DI container
     * 
     * @var ContainerBuilder
     */
    private $container = null;

    /**
     * path to di config file
     * 
     * @var string
     */
    private $diFile = null;

    /**
     * contructs the class.
     * 
     * @param string $configFile 
     */
    public function __construct($configFile = null)
    {
        if (null === $configFile) {
            $configFile = __DIR__ . DIRECTORY_SEPARATOR . 'di.yml';
        }

        $this->diFile = $configFile;
    }


    /**
     * gets the DI container
     * 
     * @return ContainerBuild
     */
    private function getContainer()
    {
        if (null === $this->container) {
            $container = new ContainerBuilder();
            $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
            $loader->load($this->diFile);

            $this->container = $container;
        }

        return $this->container;
    }

    /**
     * gets a sage class by name
     * 
     * @param  string $key 
     * 
     * @return mixed
     */
    public function get($key)
    {
        return $this->getContainer()->get($key);
    }
}
