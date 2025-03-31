<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330082450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe ADD spell5 TINYINT(1) NOT NULL, ADD spell9 TINYINT(1) NOT NULL, ADD cantrip TINYINT(1) NOT NULL, ADD spell TINYINT(1) NOT NULL, ADD infusion TINYINT(1) NOT NULL, ADD rage TINYINT(1) NOT NULL, ADD martial TINYINT(1) NOT NULL, ADD sneak TINYINT(1) NOT NULL, ADD sorcery TINYINT(1) NOT NULL, ADD slot TINYINT(1) NOT NULL, ADD invocation TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe DROP spell5, DROP spell9, DROP cantrip, DROP spell, DROP infusion, DROP rage, DROP martial, DROP sneak, DROP sorcery, DROP slot, DROP invocation');
    }
}
