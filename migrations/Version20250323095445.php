<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323095445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence ADD category VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE creature_type DROP abbreviation');
        $this->addSql('ALTER TABLE damage CHANGE abbreviation abbreviation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE feat ADD d1 VARCHAR(1000) NOT NULL, ADD d2 VARCHAR(1000) DEFAULT NULL, ADD d3 VARCHAR(1000) DEFAULT NULL, ADD d4 VARCHAR(1000) DEFAULT NULL, ADD d5 VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE language ADD abbreviation VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence DROP category');
        $this->addSql('ALTER TABLE creature_type ADD abbreviation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE damage CHANGE abbreviation abbreviation VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE feat DROP d1, DROP d2, DROP d3, DROP d4, DROP d5');
        $this->addSql('ALTER TABLE language DROP abbreviation');
    }
}
