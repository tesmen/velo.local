<?php

namespace VelovitoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VelovitoBundle\C;

class DeployCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('deploy')
            ->setDescription('Greet someone')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Who do you want to greet?'
            )
            ->addOption(
                'yell',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will yell in uppercase letters'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get(C::MODEL_MAINTENANCE)->loadRoles();
        $this->getContainer()->get(C::MODEL_MAINTENANCE)->loadCatalogCategories();
        $this->getContainer()->get(C::MODEL_MAINTENANCE)->loadCatalogItems();
        $this->getContainer()->get(C::MODEL_MAINTENANCE)->loadCurrencys();
    }
}