<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241208032912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedback ADD owned_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D22944585E70BCD7 FOREIGN KEY (owned_by_id) REFERENCES "user" (id)');
        $this->addSql('CREATE INDEX IDX_D22944585E70BCD7 ON feedback (owned_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT FK_D22944585E70BCD7');
        $this->addSql('DROP INDEX IDX_D22944585E70BCD7');
        $this->addSql('ALTER TABLE feedback DROP owned_by_id');
    }
}
