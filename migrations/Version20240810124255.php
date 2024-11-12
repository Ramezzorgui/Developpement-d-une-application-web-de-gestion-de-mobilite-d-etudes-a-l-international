public function up(Schema $schema): void
{
    $table = $schema->getTable('resultat');

    // Add postulation_id column if it does not exist
    if (!$table->hasColumn('postulation_id')) {
        $this->addSql('ALTER TABLE resultat ADD postulation_id INT DEFAULT NULL');
    }

    // Create index if it does not exist
    if (!$table->hasIndex('IDX_E7DB5DE2D749FDF1')) {
        $this->addSql('CREATE INDEX IDX_E7DB5DE2D749FDF1 ON resultat (postulation_id)');
    }

    // Add foreign key constraint if it does not exist
    // Note: Ensure that the `postulation` table and `id` column exist before adding the constraint
    $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2D749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id)');
}

public function down(Schema $schema): void
{
    $table = $schema->getTable('resultat');

    // Drop foreign key constraint if it exists
    if ($table->hasForeignKey('FK_E7DB5DE2D749FDF1')) {
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2D749FDF1');
    }

    // Drop index if it exists
    if ($table->hasIndex('IDX_E7DB5DE2D749FDF1')) {
        $this->addSql('DROP INDEX IDX_E7DB5DE2D749FDF1 ON resultat');
    }

    // Drop column if it exists
    if ($table->hasColumn('postulation_id')) {
        $this->addSql('ALTER TABLE resultat DROP postulation_id');
    }
}
