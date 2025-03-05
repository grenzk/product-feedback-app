<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241212103801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD owned_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment DROP author');
        $this->addSql('ALTER TABLE comment DROP author_handle');
        $this->addSql('ALTER TABLE comment DROP published_at');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5E70BCD7 FOREIGN KEY (owned_by_id) REFERENCES "user" (id)');
        $this->addSql('CREATE INDEX IDX_9474526C5E70BCD7 ON comment (owned_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C5E70BCD7');
        $this->addSql('DROP INDEX IDX_9474526C5E70BCD7');
        $this->addSql('ALTER TABLE comment ADD author VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD author_handle VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE comment DROP owned_by_id');
        $this->addSql('COMMENT ON COLUMN comment.published_at IS \'(DC2Type:datetime_immutable)\'');
    }
}
