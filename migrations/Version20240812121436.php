<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240812121436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add notification and resultat tables, and update postulation table.';
    }

    public function up(Schema $schema): void
    {
        // Check if 'notification' table already exists
        if (!$schema->hasTable('notification')) {
            $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, offre_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, type VARCHAR(50) NOT NULL, is_new TINYINT(1) NOT NULL, link VARCHAR(255) DEFAULT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), INDEX IDX_BF5476CA4CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
            $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
            $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA4CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id)');
        }

        // Check if 'resultat' table already exists
        if (!$schema->hasTable('resultat')) {
            $this->addSql('CREATE TABLE resultat (id INT AUTO_INCREMENT NOT NULL, postulation_id INT NOT NULL, user_id INT NOT NULL, offres_id INT NOT NULL, score DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_E7DB5DE2D749FDF1 (postulation_id), INDEX IDX_E7DB5DE2A76ED395 (user_id), INDEX IDX_E7DB5DE26C83CD9F (offres_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
            $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2D749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id)');
            $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
            $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE26C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id)');
        }

        // Update the postulation table
        $this->addSql('ALTER TABLE postulation CHANGE moy1 moy1 DOUBLE PRECISION NOT NULL, CHANGE moy2 moy2 DOUBLE PRECISION NOT NULL, CHANGE moy3 moy3 DOUBLE PRECISION NOT NULL, CHANGE score score DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Rollback changes
        if ($schema->hasTable('notification')) {
            $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
            $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA4CC8505A');
            $this->addSql('DROP TABLE notification');
        }

        if ($schema->hasTable('resultat')) {
            $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2D749FDF1');
            $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2A76ED395');
            $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE26C83CD9F');
            $this->addSql('DROP TABLE resultat');
        }

        // Revert the postulation table changes
        $this->addSql('ALTER TABLE postulation CHANGE moy1 moy1 INT NOT NULL, CHANGE moy2 moy2 INT NOT NULL, CHANGE moy3 moy3 INT NOT NULL, CHANGE score score INT NOT NULL');
    }
}
