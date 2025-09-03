<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250825152007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add created_at and modified_at columns to categorie and product tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE categorie ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD modified_at DATETIME DEFAULT NULL');

      
        $this->addSql('UPDATE categorie SET created_at = NOW() WHERE created_at IS NULL');

        $this->addSql('UPDATE product SET created_at = NOW() WHERE created_at IS NULL');

        $this->addSql('ALTER TABLE categorie MODIFY created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE product MODIFY created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema): void
    {
        // Remove the columns
        $this->addSql('ALTER TABLE categorie DROP created_at, DROP modified_at');
        $this->addSql('ALTER TABLE product DROP created_at, DROP modified_at');
    }
}
