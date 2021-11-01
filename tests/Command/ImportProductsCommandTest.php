<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ImportProductsCommandTest extends KernelTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testExecute(int $qtySuccessfully, array $rows)
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $tmpFilename = '/tmp/stock.csv';
        $this->createCsvFileFromArray($tmpFilename, $rows);

        $command = $application->find('app:import-products');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filename' => $tmpFilename,
            '--test' => null,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Warning: this command is in test mode!', $output);
        $qtyProcessed = count($rows);
        $this->assertStringContainsString("Processed {$qtyProcessed} row", $output);
        $this->assertStringContainsString("Successfully {$qtySuccessfully} row", $output);

        unlink($tmpFilename);
    }

    public function dataProvider(): array
    {
        /*
         * [qtySuccessfully, rows]
         */
        return [
            [0, []],
            [1, [[
                'Product Name' => 'name',
                'Product Description' => 'description',
                'Product Code' => 'code',
                'Stock' => 10,
                'Cost in GBP' => 5,
                'Discontinued' => 'yes',
            ]]],
        ];
    }

    private function createCsvFileFromArray(string $filename, array $rows): void
    {
        $fp = fopen($filename, 'w');

        if (false === empty($rows)) {
            fputcsv($fp, array_keys($rows[0]));
            foreach ($rows as $row) {
                fputcsv($fp, $row);
            }
        }

        fclose($fp);
    }
}
