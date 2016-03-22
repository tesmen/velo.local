<?php

namespace VelovitoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VelovitoBundle\C;

class PhotoDuplicatesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('photo:remove-dup');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository(C::REPO_PHOTO_FILE);
        $ents = $repo->findAll();
        $c = 0;

        foreach ($ents as $ent) {
            $sameNameFiles = $repo->findBy(['fileName' => $ent->getFileName()]);

            if (count($sameNameFiles) > 1) {
                array_shift($sameNameFiles);
                foreach ($sameNameFiles as $fileToRemove) {
                    $c++;
                    $em->remove($fileToRemove);
                }

                $em->flush();
            }
        }

        $em->flush();

        $output->writeln("removed $c records");

    }
}