<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817122405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Check if the 'status' column doesn't already exist to prevent duplicate addition
        $schemaManager = $this->connection->getSchemaManager();
        if (!$schemaManager->tablesExist('resultat') || !$schemaManager->listTableColumns('resultat')['status']) {
            $this->addSql('ALTER TABLE resultat ADD status VARCHAR(255) NOT NULL');
        }
    }
    

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resultat DROP status');
    }
}
