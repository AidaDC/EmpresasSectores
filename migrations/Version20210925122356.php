<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210925122356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empresa DROP FOREIGN KEY empresa_sector');
        $this->addSql('DROP INDEX empresa_sector_idx ON empresa');
        $this->addSql('ALTER TABLE sector CHANGE nombre nombre VARCHAR(150) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Empresa ADD CONSTRAINT empresa_sector FOREIGN KEY (sector) REFERENCES sector (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX empresa_sector_idx ON Empresa (sector)');
        $this->addSql('ALTER TABLE Sector CHANGE nombre nombre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
