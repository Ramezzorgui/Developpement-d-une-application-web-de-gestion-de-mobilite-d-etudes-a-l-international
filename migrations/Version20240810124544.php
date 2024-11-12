public function up(Schema $schema): void
{
    // Add index if it does not exist
    if (!$schema->getTable('resultat')->hasIndex('IDX_E7DB5DE2D749FDF1')) {
        $this->addSql('CREATE INDEX IDX_E7DB5DE2D749FDF1 ON resultat (postulation_id)');
    }

    // Add foreign key constraint if it does not exist
    $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2D749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id)');
}

public function down(Schema $schema): void
{
    // Drop foreign key constraint if it exists
    if ($schema->getTable('resultat')->hasForeignKey('FK_E7DB5DE2D749FDF1')) {
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2D749FDF1');
    }

    // Drop index if it exists
    if ($schema->getTable('resultat')->hasIndex('IDX_E7DB5DE2D749FDF1')) {
        $this->addSql('DROP INDEX IDX_E7DB5DE2D749FDF1 ON resultat');
    }
}
