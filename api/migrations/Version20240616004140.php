<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240616004140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add isPromoted field to Book entity and set default to false';
    }

    public function up(Schema $schema): void
    {
        // Add isPromoted column
        $this->addSql('ALTER TABLE book ADD is_promoted BOOLEAN DEFAULT FALSE NOT NULL');
        // Set default value for existing records
        $this->addSql('UPDATE book SET is_promoted = FALSE');
    }

    public function down(Schema $schema): void
    {
        // Remove isPromoted column
        $this->addSql('ALTER TABLE book DROP is_promoted');
    }
}
