<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240811125946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique index on username and handle existing duplicates.';
    }

    public function up(Schema $schema): void
    {
        // Add the username column if it does not exist
        if (!$schema->hasTable('user')) {
            // Table does not exist, so we need to stop migration
            return;
        }
        
        $table = $schema->getTable('user');
        if (!$table->hasColumn('username')) {
            // If username column does not exist, create it
            $this->addSql('ALTER TABLE user ADD username VARCHAR(255) NOT NULL');
        }

        // Remove any duplicate entries if they exist
        $this->addSql('DELETE FROM user WHERE username IS NOT NULL AND id NOT IN (
            SELECT MIN(id) FROM user GROUP BY username
        )');

        // Create the unique index
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema): void
    {
        // Drop the unique index
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');

        // Optionally, remove the username column if needed
        // Uncomment the following line if you want to drop the column
        // $this->addSql('ALTER TABLE user DROP COLUMN username');
    }
}
