<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240811124134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add foreign key constraints and index for offres_id in the resultat table.';
    }

    public function up(Schema $schema): void
    {
        // Check if the column already exists
        $columns = $this->connection->getSchemaManager()->listTableColumns('resultat');
        if (!array_key_exists('offres_id', $columns)) {
            $this->addSql('ALTER TABLE resultat ADD offres_id INT NOT NULL');
        }

        // Check if the foreign key constraint already exists
        $existingConstraints = $this->getExistingConstraints('resultat');
        if (!in_array('FK_E7DB5DE26C83CD9F', $existingConstraints)) {
            $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE26C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id)');
        }

        // Check if the index already exists
        $existingIndexes = $this->getExistingIndexes('resultat');
        if (!in_array('IDX_E7DB5DE26C83CD9F', $existingIndexes)) {
            $this->addSql('CREATE INDEX IDX_E7DB5DE26C83CD9F ON resultat (offres_id)');
        }
    }

    public function down(Schema $schema): void
    {
        // Check if the foreign key constraint exists before dropping
        $existingConstraints = $this->getExistingConstraints('resultat');
        if (in_array('FK_E7DB5DE26C83CD9F', $existingConstraints)) {
            $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE26C83CD9F');
        }

        // Check if the index exists before dropping
        $existingIndexes = $this->getExistingIndexes('resultat');
        if (in_array('IDX_E7DB5DE26C83CD9F', $existingIndexes)) {
            $this->addSql('DROP INDEX IDX_E7DB5DE26C83CD9F ON resultat');
        }

        // Check if the column exists before dropping
        $columns = $this->connection->getSchemaManager()->listTableColumns('resultat');
        if (array_key_exists('offres_id', $columns)) {
            $this->addSql('ALTER TABLE resultat DROP COLUMN offres_id');
        }
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
