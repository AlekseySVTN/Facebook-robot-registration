<?php

namespace App\Command;

use App\Utils\Facebook;
use App\Utils\OnlineSim;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class JustTestCommand extends Command
{
    // ...

    public function __construct()
    {


        parent::__construct();
    }

    public function configure()
    {
        $this
            // имя команды (часть после "bin/console")
            ->setName('app:just-test')

            // краткое описание, отображающееся при запуске "php bin/console list"
            ->setDescription('test message')

            // полное описание команды, отображающееся при запуске команды
            // с опцией "--help"
            ->setHelp('This command allows you to create a user...')
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        Facebook::createAccountByPhantomJs();

    }


}