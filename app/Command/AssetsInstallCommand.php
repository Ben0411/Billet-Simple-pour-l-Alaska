<?php

namespace Framework\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class AssetsInstallCommand extends Command
{
    protected function configure()
    {
        $this->setName('assets:install');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {   
        $cache = new FilesystemAdapter();
        $assetsVersion = $cache->getItem('assets.version');
        $assetsVersion->set($assetsVersion->get()+1);
        $cache->save($assetsVersion);
    }
}
