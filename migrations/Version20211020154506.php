<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Create tblProductData
 */
final class Version20211020154506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tblProductData';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE tblProductData (
            intProductDataId int(10) unsigned NOT NULL AUTO_INCREMENT,
            strProductName varchar(50) NOT NULL,
            strProductDesc varchar(255) NOT NULL,
            strProductCode varchar(10) NOT NULL,
            dtmAdded datetime DEFAULT NULL,
            dtmDiscontinued datetime DEFAULT NULL,
            stmTimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (intProductDataId),
            UNIQUE KEY (strProductCode)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores product data'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tblProductData');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
