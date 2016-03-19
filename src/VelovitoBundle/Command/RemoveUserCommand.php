<?php

namespace VelovitoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VelovitoBundle\C;

class RemoveUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $ent = $em->getRepository(C::REPO_USER)->findOneByEmail('ksenyastep@mail.ru');
        $em->remove($ent);
        $em->flush();

    }
}