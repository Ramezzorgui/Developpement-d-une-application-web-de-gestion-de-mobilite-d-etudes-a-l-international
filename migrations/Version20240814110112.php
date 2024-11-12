<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240814110112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add foreign key constraint and index to the postulation table for offre_id.';
    }

    public function up(Schema $schema): void
    {
        // Check if 'offre_id' column exists
        if ($schema->getTable('postulation')->hasColumn('offre_id')) {
            // Drop existing constraint and index if they exist
            if ($schema->getTable('postulation')->hasForeignKey('FK_DA7D4E9B4CC8505A')) {
                $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B4CC8505A');
            }
            if ($schema->getTable('postulation')->hasIndex('IDX_DA7D4E9B4CC8505A')) {
                $this->addSql('DROP INDEX IDX_DA7D4E9B4CC8505A ON postulation');
            }

            // Add foreign key constraint and index
            $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B4CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id) ON DELETE CASCADE');
            $this->addSql('CREATE INDEX IDX_DA7D4E9B4CC8505A ON postulation (offre_id)');
        } else {
            throw new \RuntimeException('Column offre_id is missing in postulation table.');
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->getTable('postulation')->hasColumn('offre_id')) {
            // Drop foreign key constraint and index
            $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B4CC8505A');
            $this->addSql('DROP INDEX IDX_DA7D4E9B4CC8505A ON postulation');
        }
    }
}
