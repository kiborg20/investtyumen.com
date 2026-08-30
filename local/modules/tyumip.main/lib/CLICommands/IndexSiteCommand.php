<?php

namespace Tyumip\Main\CLICommands;

use Bitrix\Main\DB\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IndexSiteCommand extends Command
{
    /**
     * Описание команды
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('index:siteindex')
            ->setDescription('Индексация страниц');
    }


    /**
     * Получение slug и запись в необходимый файл
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Начинаем индексацию страниц');
        $searchSe = new \Tyumip\Main\Service\SearchIndexer();
        try {
            $searchSe->startIndexing();
        } catch (Exception $e) {
            $output->writeln('Индексация выполнена с ошибкой: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('Индексация выполнена успешна');

        return Command::SUCCESS;
    }
}