<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240728232843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
{
    // Check if the column 'identifiant' does not exist before adding it
    $table = $schema->getTable('user'); // Replace 'user' with your table name

    if (!$table->hasColumn('identifiant')) {
        $this->addSql('ALTER TABLE user ADD identifiant VARCHAR(255) NOT NULL');
    }
}



    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE offres');
    }
}
