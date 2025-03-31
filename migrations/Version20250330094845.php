<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330094845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill DROP type, DROP attack_type, DROP damage, DROP target');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill ADD type VARCHAR(10) DEFAULT NULL, ADD attack_type VARCHAR(3) DEFAULT NULL, ADD damage VARCHAR(100) DEFAULT NULL, ADD target VARCHAR(100) DEFAULT NULL');
    }
}
