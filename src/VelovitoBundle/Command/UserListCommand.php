<?php

namespace VelovitoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VelovitoBundle\C;

class UserListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('user:list');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $ents = $em->getRepository(C::REPO_USER)->findAll();

        foreach ($ents as $user) {
            $output->writeln(
                sprintf(
                    '%s - %s - %s - %s - ',
                    $user->getId(),
                    $user->getUsername(),
                    $user->getEmail(),
                    $user->getRegisteredDate()->format('d-m-y')
                )
            );
        }
    }
}