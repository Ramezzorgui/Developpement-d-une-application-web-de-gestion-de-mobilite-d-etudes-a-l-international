<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240811122956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Sets up foreign key constraints on the user_id and postulation_id columns in the resultat table.';
    }

    public function up(Schema $schema): void
    {
        // Ensure all postulation_id values in the resultat table are valid
        $this->addSql('DELETE FROM resultat WHERE postulation_id NOT IN (SELECT id FROM postulation)');

        // Check if the foreign key constraint already exists
        $existingConstraints = $this->getExistingConstraints('resultat');
        if (!in_array('FK_E7DB5DE2D749FDF1', $existingConstraints)) {
            $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2D749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id)');
        }

        if (!in_array('FK_E7DB5DE2A76ED395', $existingConstraints)) {
            $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        }

        // Check if the index already exists
        $existingIndexes = $this->getExistingIndexes('resultat');
        if (!in_array('IDX_E7DB5DE2A76ED395', $existingIndexes)) {
            $this->addSql('CREATE INDEX IDX_E7DB5DE2A76ED395 ON resultat (user_id)');
        }
    }

    public function down(Schema $schema): void
    {
        // Drop the foreign key constraints and index
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY IF EXISTS FK_E7DB5DE2D749FDF1');
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY IF EXISTS FK_E7DB5DE2A76ED395');
        $this->addSql('DROP INDEX IF EXISTS IDX_E7DB5DE2A76ED395 ON resultat');
    }

    private function getExistingConstraints(string $tableName): array
    {
        $constraints = [];
        $result = $this->connection->executeQuery("
            SELECT CONSTRAINT_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = ?
        ", [$tableName]);

        while ($row = $result->fetchAssociative()) {
            $constraints[] = $row['CONSTRAINT_NAME'];
        }

        return $constraints;
    }

    private function getExistingIndexes(string $tableName): array
    {
        $indexes = [];
        $result = $this->connection->executeQuery("
            SHOW INDEX FROM $tableName
        ");

        while ($row = $result->fetchAssociative()) {
            $indexes[] = $row['Key_name'];
        }

        return $indexes;
    }
}
