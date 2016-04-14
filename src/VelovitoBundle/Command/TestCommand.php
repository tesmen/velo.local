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
//        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
//        $repo = $em->getRepository(C::REPO_CITY);
//        $repo->update(2, ['name' => 'blizzard']);


//        $repo->create(
//            [
//                'id'   => 2,
//                'name' => 'barbaz',
//            ]
//        );


//        $this->getContainer()->get(C::MODEL_MAINTENANCE)->loadCatalogCategories();

        $parents = $this->getContainer()->get(C::MODEL_DEFAULT)->getMenuParentCategories();

        foreach ($parents as $parent) {
            var_dump($parent->getId());

            foreach ($parent->getCatalogItems() as $item) {
                var_dump('   --  '.$item->getId());
            }

        }

    }
}