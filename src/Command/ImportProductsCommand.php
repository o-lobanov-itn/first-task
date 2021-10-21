<?php

namespace App\Command;

use App\Entity\ProductData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ImportProductsCommand extends Command
{
    private const STATUS_SUCCESSFUL = 'successful';
    private const STATUS_SKIPPED = 'skipped';

    protected static $defaultName = 'app:import-products';

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to import products from a CSV file')
            ->addArgument('filename', InputArgument::REQUIRED, 'The filename of the import CSV file.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileName = $input->getArgument('filename');

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $rows = $serializer->decode(file_get_contents($fileName), 'csv');

        foreach ($rows as &$row) {
            $name = $row['Product Name'];
            $desc = $row['Product Description'];
            $code = $row['Product Code'];
            $stock = (int)($row['Stock'] ?? 0);
            $price = isset($row['Cost in GBP']) ? (float)$row['Cost in GBP'] : null;
            $discontinued = $row['Discontinued'] ?? null;

            $product = (new ProductData())
                ->setProductName($name)
                ->setProductDesc($desc)
                ->setProductCode($code)
                ->setStock($stock)
                ->setPrice($price);

            if ($discontinued === 'yes') {
                $product->setDiscontinued(new \DateTime());
            }

            try {
                $this->em->persist($product);
                $this->em->flush();
                $row['status'] = self::STATUS_SUCCESSFUL;
            } catch (\Exception $exception) {
                $row['status'] = self::STATUS_SKIPPED;
            }
        }

        $qty = count($rows);
        $output->writeln("Processed {$qty} row(s)");
        $qty = $this->getRowsCountByStatus($rows, self::STATUS_SUCCESSFUL);
        $output->writeln("Successfully {$qty} row(s)");
        $qty = $this->getRowsCountByStatus($rows, self::STATUS_SKIPPED);
        $output->writeln("Skipped {$qty} row(s)");

        return Command::SUCCESS;
    }

    private function getRowsCountByStatus(array $rows, string $status): int
    {
        return count(array_filter($rows, fn($r) => $r['status'] === $status));
    }
}