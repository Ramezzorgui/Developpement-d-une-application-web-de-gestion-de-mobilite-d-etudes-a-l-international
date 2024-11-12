<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729150211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Get the schema manager
        $schemaManager = $this->connection->getSchemaManager();
    
        // Check if the table already exists
        if (!$schemaManager->tablesExist(['resultat'])) {
            $this->addSql('CREATE TABLE resultat (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT DEFAULT NULL,
                -- Other columns
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }
    }
    

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2A76ED395');
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE26C83CD9F');
        $this->addSql('DROP TABLE resultat');
    }
}
