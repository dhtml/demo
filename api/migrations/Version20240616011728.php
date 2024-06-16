<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240616011728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add slug field to Book entity and set unique values for existing records';
    }

    public function up(Schema $schema): void
    {
        // Add slug column
        $this->addSql('ALTER TABLE book ADD slug VARCHAR(255) NOT NULL');

        // Set slug for existing records
        $this->addSql("UPDATE book SET slug = 'book-' || id");

        // Ensure slug is unique
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331989D9B62 ON book (slug)');
    }

    public function down(Schema $schema): void
    {
        // Drop slug column
        $this->addSql('ALTER TABLE book DROP slug');
    }
}
