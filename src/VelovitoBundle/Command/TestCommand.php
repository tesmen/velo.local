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
        $this->getContainer()->get(C::MODEL_DOCUMENT)->resizeImage('50087bffd8f798fb984db6c1ce3edc86.png');
    }
}