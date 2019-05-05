<?php

namespace App\Command;

use App\Utils\OnlineSim;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CreateNewFbAccountCommand extends Command
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
            ->setName('app:create-new-fb-account')

            // краткое описание, отображающееся при запуске "php bin/console list"
            ->setDescription('Creates a new fb-account')

            // полное описание команды, отображающееся при запуске команды
            // с опцией "--help"
            ->setHelp('This command allows you to create a user...')
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service_name = "FB";

        // выводит множество строк в консоль (добавляя "\n" в конце каждой строки)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        // выводит сообщение с последующим "\n"
        $output->writeln('Ух ты! Запрашиваем tzid');

        $tzid = OnlineSim::getTz(OnlineSim::$service_array[$service_name]);

        $output->writeln('Tzid === '.$tzid);


        $output->writeln('Что там с номером?');

        if($tzid){
            $phone_number = OnlineSim::getPhoneNumber($tzid);
        }

        if($phone_number){
            $output->writeln('Вам достался номер '.$phone_number.' На него можно регистрировать пользователя для '."FB");

            $output->writeln('С помощью фейсбуук api отправляем POST на новую регистрацию');
            $message = OnlineSim::getCodeFromSms($tzid);

            if($message["status"] == "success" && $message["code"]){
                $output->writeln('Получено смс с кодом'. $message["code"]);

                $output->writeln('Отправляем на фейсбук запрос подтверждения');
            }else{
                $output->writeln('Произошла ошибка');
                $output->writeln("Status - ".$message["status"]." StatusCode - ".$message["status_code"]);
            }
            $output->writeln('С помощью фейсбуук api отправляем POST на новую регистрацию');



        }else{
            $output->writeln('Нет телефона');
        }






    }


}