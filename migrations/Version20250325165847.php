<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325165847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe ADD spellcasting_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF9633EF40B5 FOREIGN KEY (spellcasting_id) REFERENCES classe_spellcasting (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F87BF9633EF40B5 ON classe (spellcasting_id)');
        $this->addSql('ALTER TABLE classe_level DROP FOREIGN KEY FK_D39D982B33EF40B5');
        $this->addSql('DROP INDEX UNIQ_D39D982B33EF40B5 ON classe_level');
        $this->addSql('ALTER TABLE classe_level DROP spellcasting_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF9633EF40B5');
        $this->addSql('DROP INDEX UNIQ_8F87BF9633EF40B5 ON classe');
        $this->addSql('ALTER TABLE classe DROP spellcasting_id');
        $this->addSql('ALTER TABLE classe_level ADD spellcasting_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classe_level ADD CONSTRAINT FK_D39D982B33EF40B5 FOREIGN KEY (spellcasting_id) REFERENCES classe_spellcasting (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D39D982B33EF40B5 ON classe_level (spellcasting_id)');
    }
}
