<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250324125740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_property ADD show_skill TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE item_skill DROP show_skill, DROP optional');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_property DROP show_skill');
        $this->addSql('ALTER TABLE item_skill ADD show_skill TINYINT(1) NOT NULL, ADD optional TINYINT(1) NOT NULL');
    }
}
