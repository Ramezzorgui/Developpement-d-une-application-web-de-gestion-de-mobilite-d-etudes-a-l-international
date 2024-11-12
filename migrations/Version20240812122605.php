<?php
namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240812122605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correct foreign key references to match the existing columns';
    }

    public function up(Schema $schema): void
    {
        // Check if foreign key constraint exists before adding it
        $this->addSql('
            SET @foreignKeyConstraintExists = 0;
            SELECT COUNT(*) INTO @foreignKeyConstraintExists
            FROM information_schema.REFERENTIAL_CONSTRAINTS
            WHERE CONSTRAINT_NAME = "FK_DA7D4E9B4CC8505A";
        ');

        $this->addSql('
            SET @sql = IF(@foreignKeyConstraintExists = 0, "ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B4CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id) ON DELETE CASCADE", "SELECT \'Foreign key constraint already exists\'");
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
        ');

        // Create an index for the foreign key if it does not already exist
        $this->addSql('
            SET @indexExists = 0;
            SELECT COUNT(*) INTO @indexExists
            FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = "stages" AND TABLE_NAME = "postulation" AND INDEX_NAME = "IDX_DA7D4E9B4CC8505A";
        ');

        $this->addSql('
            SET @sql = IF(@indexExists = 0, "CREATE INDEX IDX_DA7D4E9B4CC8505A ON postulation (offre_id)", "SELECT \'Index already exists\'");
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
        ');
    }

    public function down(Schema $schema): void
    {
        // Remove the foreign key constraint if it exists
        $this->addSql('
            SET @foreignKeyConstraintExists = 0;
            SELECT COUNT(*) INTO @foreignKeyConstraintExists
            FROM information_schema.REFERENTIAL_CONSTRAINTS
            WHERE CONSTRAINT_NAME = "FK_DA7D4E9B4CC8505A";
        ');

        $this->addSql('
            SET @sql = IF(@foreignKeyConstraintExists = 0, "ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B4CC8505A", "SELECT \'Foreign key constraint does not exist\'");
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
        ');

        // Drop the index created for the foreign key if it exists
        $this->addSql('
            SET @indexExists = 0;
            SELECT COUNT(*) INTO @indexExists
            FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = "stages" AND TABLE_NAME = "postulation" AND INDEX_NAME = "IDX_DA7D4E9B4CC8505A";
        ');

        $this->addSql('
            SET @sql = IF(@indexExists = 0, "DROP INDEX IDX_DA7D4E9B4CC8505A ON postulation", "SELECT \'Index does not exist\'");
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
        ');
    }
}
