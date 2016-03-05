<?php

namespace VelovitoBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\KernelInterface;
use VelovitoBundle\C;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class DefaultModel
{
    private $em;

    public function __construct(EntityManager $em, KernelInterface $kernel)
     {
        $this->em = $em;
        $this->kernel = $kernel;
    }

    public function loadConfigFromYaml($config)
    {
        $yaml = new Parser();
        try {
            $path = $this->kernel->locateResource('@VelovitoBundle/Resources/config/'.$config.'.yml');

        } catch (ParseException $e) {
            throw new \Exception($config.'.yml not found');
        }

        try {
            $value = $yaml->parse(file_get_contents($path));
        } catch (ParseException $e) {
            throw new \Exception(sprintf('Unable to parse the YAML string: %s', $e->getMessage()));
        }

        return $value;
    }
}
