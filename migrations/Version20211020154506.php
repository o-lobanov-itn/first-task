<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Create product_data
 */
final class Version20211020154506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create product_data';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE product_data (
            id INT AUTO_INCREMENT NOT NULL,
            product_name VARCHAR(50) NOT NULL,
            product_desc VARCHAR(255) NOT NULL,
            product_code VARCHAR(10) NOT NULL,
            stock INT DEFAULT 0 NOT NULL,
            price DOUBLE PRECISION DEFAULT NULL,
            added DATETIME DEFAULT NULL,
            discontinued DATETIME DEFAULT NULL,
            timestamp DATETIME NOT NULL,
            PRIMARY KEY(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores product data'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE product_data');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
