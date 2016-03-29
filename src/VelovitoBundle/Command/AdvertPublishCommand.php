<?php

namespace VelovitoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VelovitoBundle\C;

class AdvertPublishCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('advert:publish');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $ents = $em->getRepository(C::REPO_ADVERTISEMENT)->findAll();
        $c = 0;

        foreach ($ents as $advert) {

            $advert->setIsPublished(true);
            $c++;
        }
        $em->flush();

        $output->writeln("Publuished $c adverts");

    }
}