<?php

namespace VelovitoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VelovitoBundle\C;

class AdvertDatesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('advert:dates');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $ents = $em->getRepository(C::REPO_ADVERTISEMENT)->findAll();

        foreach ($ents as $advert) {
            $date = new \DateTime('yesterday');
            $random = rand(0,23);
            $randomMin = rand(0,59);
            $date->modify("+ $random hours");
            $date->modify("+ $randomMin minutes");
            $advert->setCreationDate($date);

            $output->writeln(
                sprintf(
                    '%s - set date - %s',
                    $advert->getId(),
                    $date->format('d-m-y')
                )
            );
        }

        $em->flush();
    }
}