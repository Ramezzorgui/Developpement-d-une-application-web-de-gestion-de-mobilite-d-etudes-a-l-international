<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240807124411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
{
    // Alter the notification table to drop the 'offre' column only if it exists
    $schemaManager = $this->connection->getSchemaManager();
    $columns = $schemaManager->listTableColumns('notification');

    if (isset($columns['offre'])) {
        $this->addSql('ALTER TABLE notification DROP COLUMN offre');
    }

    // Add other schema changes here if needed
}

    
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA4CC8505A');
        $this->addSql('DROP INDEX IDX_BF5476CA4CC8505A ON notification');
        $this->addSql('ALTER TABLE notification ADD offre VARCHAR(255) NOT NULL, DROP offre_id');
    }
    
}
