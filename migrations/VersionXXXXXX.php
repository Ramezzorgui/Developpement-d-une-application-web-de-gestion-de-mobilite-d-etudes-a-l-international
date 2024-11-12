<?php
// src/Migrations/VersionXXXXXX.php
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class VersionXXXXXX extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE your_table DROP INDEX unique_constraint_name');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX unique_constraint_name ON your_table (column_name)');
    }
}
