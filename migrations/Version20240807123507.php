<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240807123507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update notification table to use offre_id and drop old offre column.';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('notification');

        // Add 'offre_id' column if it does not already exist
        if (!$table->hasColumn('offre_id')) {
            $this->addSql('ALTER TABLE notification ADD offre_id INT DEFAULT NULL');
        }

        // Drop 'offre' column if it exists
        if ($table->hasColumn('offre')) {
            $this->addSql('ALTER TABLE notification DROP COLUMN offre');
        }

        // Add foreign key constraint if it does not already exist
        if (!$table->hasForeignKey('FK_BF5476CA4CC8505A')) {
            $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA4CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id)');
        }

        // Add index if it does not already exist
        $indexes = $table->getIndexes();
        $indexNames = array_map(fn($index) => $index->getName(), $indexes);

        if (!in_array('IDX_BF5476CA4CC8505A', $indexNames)) {
            $this->addSql('CREATE INDEX IDX_BF5476CA4CC8505A ON notification (offre_id)');
        }
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('notification');

        // Drop foreign key constraint if it exists
        if ($table->hasForeignKey('FK_BF5476CA4CC8505A')) {
            $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA4CC8505A');
        }

        // Drop index if it exists
        $indexes = $table->getIndexes();
        $indexNames = array_map(fn($index) => $index->getName(), $indexes);

        if (in_array('IDX_BF5476CA4CC8505A', $indexNames)) {
            $this->addSql('DROP INDEX IDX_BF5476CA4CC8505A ON notification');
        }

        // Add 'offre' column if it does not already exist
        if (!$table->hasColumn('offre')) {
            $this->addSql('ALTER TABLE notification ADD offre VARCHAR(255) NOT NULL');
        }

        // Drop 'offre_id' column if it exists
        if ($table->hasColumn('offre_id')) {
            $this->addSql('ALTER TABLE notification DROP COLUMN offre_id');
        }
    }
}
