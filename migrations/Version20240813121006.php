<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240813121006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add foreign key constraints to postulation table.';
    }

    public function up(Schema $schema): void
    {
        // Ensure the tables and columns exist before adding constraints
        if ($schema->getTable('user')->hasColumn('id') && $schema->getTable('offres')->hasColumn('id')) {
            // Drop existing constraints if they exist
            if ($schema->getTable('postulation')->hasForeignKey('FK_DA7D4E9BA76ED395')) {
                $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9BA76ED395');
            }
            if ($schema->getTable('postulation')->hasForeignKey('FK_DA7D4E9B4CC8505A')) {
                $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B4CC8505A');
            }

            // Drop existing indexes if they exist
            if ($schema->getTable('postulation')->hasIndex('IDX_DA7D4E9BA76ED395')) {
                $this->addSql('DROP INDEX IDX_DA7D4E9BA76ED395 ON postulation');
            }
            if ($schema->getTable('postulation')->hasIndex('IDX_DA7D4E9B4CC8505A')) {
                $this->addSql('DROP INDEX IDX_DA7D4E9B4CC8505A ON postulation');
            }

            // Add user_id column if it doesn't exist
            if (!$schema->getTable('postulation')->hasColumn('user_id')) {
                $this->addSql('ALTER TABLE postulation ADD user_id INT DEFAULT NULL');
            }

            // Add foreign key constraints and indexes
            $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
            $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B4CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id) ON DELETE CASCADE');
            $this->addSql('CREATE INDEX IDX_DA7D4E9BA76ED395 ON postulation (user_id)');
            $this->addSql('CREATE INDEX IDX_DA7D4E9B4CC8505A ON postulation (offre_id)');
        } else {
            throw new \RuntimeException('Required tables or columns are missing.');
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9BA76ED395');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B4CC8505A');
        $this->addSql('DROP INDEX IDX_DA7D4E9BA76ED395 ON postulation');
        $this->addSql('DROP INDEX IDX_DA7D4E9B4CC8505A ON postulation');
    }
}
