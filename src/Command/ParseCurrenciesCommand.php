<?php

namespace App\Command;

use App\Repository\CurrencyRepository;
use App\Service\CurrencyService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ParseCurrenciesCommand extends Command
{
    protected static $defaultName = 'parseCurrencies';
    private $storage;

    public function __construct(CurrencyRepository $storage)
    {
        $this->storage = $storage;

        parent::__construct();
    }
    protected function configure()
    {
        $this->setDescription('Parsing the exchange rate from http://www.cbr.ru/');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title($this->getDescription());

        $service = new CurrencyService();
        $currencies = $service->getCurrencies();

        foreach ($currencies as $currency) {
            $this->storage->save($currency);
        }

        $io->success('Success!');

        return 0;
    }
}
