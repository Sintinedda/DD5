<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250326194959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sb ADD alignment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sb ADD CONSTRAINT FK_E67738BEAB7AC2A0 FOREIGN KEY (alignment_id) REFERENCES alignment (id)');
        $this->addSql('CREATE INDEX IDX_E67738BEAB7AC2A0 ON sb (alignment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sb DROP FOREIGN KEY FK_E67738BEAB7AC2A0');
        $this->addSql('DROP INDEX IDX_E67738BEAB7AC2A0 ON sb');
        $this->addSql('ALTER TABLE sb DROP alignment_id');
    }
}
