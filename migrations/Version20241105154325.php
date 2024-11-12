<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241105154325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resultat_user (id INT AUTO_INCREMENT NOT NULL, res_id INT DEFAULT NULL, re_id INT DEFAULT NULL, ress_id INT DEFAULT NULL, score INT NOT NULL, date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_2B265A684670E604 (res_id), UNIQUE INDEX UNIQ_2B265A68D0C85FA1 (re_id), INDEX IDX_2B265A68E05A09DA (ress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resultat_user ADD CONSTRAINT FK_2B265A684670E604 FOREIGN KEY (res_id) REFERENCES offres (id)');
        $this->addSql('ALTER TABLE resultat_user ADD CONSTRAINT FK_2B265A68D0C85FA1 FOREIGN KEY (re_id) REFERENCES postulation (id)');
        $this->addSql('ALTER TABLE resultat_user ADD CONSTRAINT FK_2B265A68E05A09DA FOREIGN KEY (ress_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resultat_user DROP FOREIGN KEY FK_2B265A684670E604');
        $this->addSql('ALTER TABLE resultat_user DROP FOREIGN KEY FK_2B265A68D0C85FA1');
        $this->addSql('ALTER TABLE resultat_user DROP FOREIGN KEY FK_2B265A68E05A09DA');
        $this->addSql('DROP TABLE resultat_user');
    }
}
