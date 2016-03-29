<?php

namespace VelovitoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VelovitoBundle\C;

class AdvertUnPublishCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('advert:unpublish')
            ->addOption(
                'id',
                null,
                InputOption::VALUE_REQUIRED,
                'advert id?',
                null
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $advertId = $input->getOption('id');

        if (!$advertId) {
            throw new \Exception('advert id is not entered');
        }

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository(C::REPO_ADVERTISEMENT);
        $repo->unPublish($advertId, C::ADVERT_STATUS_UNPUBLISHED);
        $em->flush();

        $output->writeln('unpublished succesfully');
    }
}