<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Add stock and price into tblProductData
 */
final class Version20211021083246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add stock and price into tblProductData';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tblProductData
            ADD stock INT DEFAULT 0 NOT NULL,
            ADD price DOUBLE PRECISION DEFAULT NULL
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tblProductData DROP stock, DROP price');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
