<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240810110632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add type, is_new, and link columns to notification table if they do not already exist.';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('notification');

        // Add 'type' column if it does not already exist
        if (!$table->hasColumn('type')) {
            $this->addSql('ALTER TABLE notification ADD type VARCHAR(50) NOT NULL');
        }

        // Add 'is_new' column if it does not already exist
        if (!$table->hasColumn('is_new')) {
            $this->addSql('ALTER TABLE notification ADD is_new TINYINT(1) NOT NULL');
        }

        // Add 'link' column if it does not already exist
        if (!$table->hasColumn('link')) {
            $this->addSql('ALTER TABLE notification ADD link VARCHAR(255) DEFAULT NULL');
        }
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('notification');

        // Drop 'type' column if it exists
        if ($table->hasColumn('type')) {
            $this->addSql('ALTER TABLE notification DROP COLUMN type');
        }

        // Drop 'is_new' column if it exists
        if ($table->hasColumn('is_new')) {
            $this->addSql('ALTER TABLE notification DROP COLUMN is_new');
        }

        // Drop 'link' column if it exists
        if ($table->hasColumn('link')) {
            $this->addSql('ALTER TABLE notification DROP COLUMN link');
        }
    }
}
