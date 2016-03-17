<?php

namespace VelovitoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VelovitoBundle\C;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $a = $this->getContainer()->get(C::MODEL_DOCUMENT)->moveUploadedFileTo(
            '2b04701773d8085f0c09de3a51c2805b.png',
            $this->getContainer()->get(C::MODEL_DEFAULT)->getImageOriginalsDir('01.jpg')
            );

        var_dump($a);
    }
}