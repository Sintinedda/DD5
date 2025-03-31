<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329102714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe ADD d2 VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477F43C4D5C');
        $this->addSql('DROP INDEX IDX_5E3DE477F43C4D5C ON skill');
        $this->addSql('ALTER TABLE skill DROP feat_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe DROP d2');
        $this->addSql('ALTER TABLE skill ADD feat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477F43C4D5C FOREIGN KEY (feat_id) REFERENCES feat (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477F43C4D5C ON skill (feat_id)');
    }
}
