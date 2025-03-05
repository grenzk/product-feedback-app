<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220084303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE upvote (id SERIAL NOT NULL, feedback_id INT NOT NULL, owned_by_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_68AB8766D249A887 ON upvote (feedback_id)');
        $this->addSql('CREATE INDEX IDX_68AB87665E70BCD7 ON upvote (owned_by_id)');
        $this->addSql('ALTER TABLE upvote ADD CONSTRAINT FK_68AB8766D249A887 FOREIGN KEY (feedback_id) REFERENCES feedback (id)');
        $this->addSql('ALTER TABLE upvote ADD CONSTRAINT FK_68AB87665E70BCD7 FOREIGN KEY (owned_by_id) REFERENCES "user" (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE upvote DROP CONSTRAINT FK_68AB8766D249A887');
        $this->addSql('ALTER TABLE upvote DROP CONSTRAINT FK_68AB87665E70BCD7');
        $this->addSql('DROP TABLE upvote');
    }
}
