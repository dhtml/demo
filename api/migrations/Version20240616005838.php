<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240616005838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change isPromoted to promotionStatus in Book entity';
    }

    public function up(Schema $schema): void
    {
        // Add promotionStatus column
        $this->addSql("ALTER TABLE book ADD promotion_status VARCHAR(10) DEFAULT 'None' NOT NULL");

        // Convert isPromoted values to promotionStatus
        $this->addSql("UPDATE book SET promotion_status = CASE WHEN is_promoted = FALSE THEN 'None' ELSE 'Basic' END");

        // Drop isPromoted column
        $this->addSql('ALTER TABLE book DROP is_promoted');
    }

    public function down(Schema $schema): void
    {
        // Re-add isPromoted column
        $this->addSql('ALTER TABLE book ADD is_promoted BOOLEAN DEFAULT FALSE NOT NULL');

        // Convert promotionStatus values back to isPromoted
        $this->addSql("UPDATE book SET is_promoted = CASE WHEN promotion_status = 'None' THEN FALSE ELSE TRUE END");

        // Drop promotionStatus column
        $this->addSql('ALTER TABLE book DROP promotion_status');
    }
}
