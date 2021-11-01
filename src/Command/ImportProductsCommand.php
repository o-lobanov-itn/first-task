<?php

namespace App\Command;

use App\Service\Import\CsvService;
use App\Service\Import\ProductDataFactory;
use App\Service\Import\RuleEngine;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportProductsCommand extends Command
{
    protected static $defaultName = 'app:import-products';

    private int $qtyProcessed;
    private int $qtySuccessfully;

    private EntityManagerInterface $em;
    private ProductDataFactory $productDataFactory;
    private RuleEngine $ruleEngine;
    private CsvService $csvService;

    public function __construct(
        EntityManagerInterface $em,
        ProductDataFactory $productDataFactory,
        RuleEngine $ruleEngine,
        CsvService $csvService
    ) {
        $this->qtyProcessed = 0;
        $this->qtySuccessfully = 0;

        $this->em = $em;
        $this->productDataFactory = $productDataFactory;
        $this->ruleEngine = $ruleEngine;
        $this->csvService = $csvService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to import products from a CSV file')
            ->addArgument('filename', InputArgument::REQUIRED, 'The filename of the import CSV file.')
            ->addOption(
                'test',
                null,
                InputOption::VALUE_OPTIONAL,
                'Is it test (without saving data)?',
                false
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileName = $input->getArgument('filename');
        $isTest = null === $input->getOption('test');

        if (true === $isTest) {
            $output->writeln('Warning: this command is in test mode!');
        }

        $this->csvService->init($fileName);

        while ($row = $this->csvService->getRow()) {
            ++$this->qtyProcessed;

            try {
                $product = $this->productDataFactory->createFromRow($row);

                $this->ruleEngine->check($product);

                if (false === $isTest) {
                    $this->em->persist($product);
                    $this->em->flush();
                }

                ++$this->qtySuccessfully;
            } catch (Exception $exception) {
                $output->writeln(sprintf(
                    'Skipped line %d: %s',
                    $this->csvService->getRowNumber(),
                    $exception->getMessage()
                ));
            }
        }

        $output->writeln('===================================');
        $output->writeln(sprintf(
            'Processed %d row(s)',
            $this->qtyProcessed
        ));
        $output->writeln(sprintf(
            'Successfully %d row(s)',
            $this->qtySuccessfully
        ));

        if ($this->qtyProcessed != $this->qtySuccessfully) {
            $output->writeln(sprintf(
                'Skipped %d row(s)',
                $this->qtyProcessed - $this->qtySuccessfully
            ));
        }

        return Command::SUCCESS;
    }
}
