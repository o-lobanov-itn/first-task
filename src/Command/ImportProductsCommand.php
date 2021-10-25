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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportProductsCommand extends Command
{
    private const STATUS_SUCCESSFUL = 'successful';
    private const STATUS_SKIPPED = 'skipped';

    protected static $defaultName = 'app:import-products';

    private array $rows;
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
        $this->rows = [];
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

        $this->rows = $this->csvService->import($fileName);

        $output->writeln(sprintf(
            'Processing %d row(s):',
            count($this->rows)
        ));

        foreach ($this->rows as $i => $row) {
            try {
                $product = $this->productDataFactory->createFromRow($row);

                $this->ruleEngine->check($product);

                if (false === $isTest) {
                    $this->em->persist($product);
                    $this->em->flush();
                }

                $this->setRowStatus($i, self::STATUS_SUCCESSFUL);
            } catch (Exception $exception) {
                $this->setRowStatus($i, self::STATUS_SKIPPED);
                $this->setRowError($i, $exception->getMessage());
            }
        }

        $output->writeln(sprintf(
            'Processed %d row(s)',
            count($this->rows)
        ));
        $output->writeln(sprintf(
            'Successfully %d row(s)',
            $this->getRowsCountByStatus(self::STATUS_SUCCESSFUL)
        ));

        $skippedQty = $this->getRowsCountByStatus(self::STATUS_SKIPPED);
        if ($skippedQty > 0) {
            $output->writeln(sprintf(
                'Skipped %d row(s):',
                $skippedQty
            ));

            foreach ($this->rows as $i => $row) {
                if (self::STATUS_SKIPPED !== $row['status']) {
                    continue;
                }

                $output->writeln(sprintf(
                    'Line %d with the code %s: %s',
                    $i + 2,
                    $row['Product Code'] ?? 'Unknown',
                    $row['error'] ?? '-'
                ));
            }
        }

        return Command::SUCCESS;
    }

    private function setRowStatus(int $index, string $status): void
    {
        $this->rows[$index]['status'] = $status;
    }

    private function setRowError(int $index, mixed $error): void
    {
        $this->rows[$index]['error'] = is_array($error) ? implode("\n", $error) : (string) $error;
    }

    private function getRowsCountByStatus(string $status): int
    {
        $count = 0;

        foreach ($this->rows as $row) {
            if ($row['status'] === $status) {
                ++$count;
            }
        }

        return $count;
    }
}
