<?php
namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240815112456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user_id column with constraints to the postulation table if it does not already exist';
    }

    public function up(Schema $schema): void
    {
        // Check if the column already exists
        $existingColumn = $this->connection->fetchOne("
            SELECT COUNT(*)
            FROM information_schema.COLUMNS
            WHERE TABLE_NAME = 'postulation'
            AND COLUMN_NAME = 'user_id'
        ");

        if ($existingColumn == 0) {
            // Add the column if it does not exist
            $this->addSql('ALTER TABLE postulation ADD user_id INT NOT NULL');
            $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
            $this->addSql('CREATE INDEX IDX_DA7D4E9BA76ED395 ON postulation (user_id)');
        }
    }

    public function down(Schema $schema): void
    {
        // Check if the column exists before trying to drop it
        $existingColumn = $this->connection->fetchOne("
            SELECT COUNT(*)
            FROM information_schema.COLUMNS
            WHERE TABLE_NAME = 'postulation'
            AND COLUMN_NAME = 'user_id'
        ");

        if ($existingColumn > 0) {
            $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9BA76ED395');
            $this->addSql('DROP INDEX IDX_DA7D4E9BA76ED395 ON postulation');
            $this->addSql('ALTER TABLE postulation DROP COLUMN user_id');
        }
    }
}
