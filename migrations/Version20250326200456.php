<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250326200456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sb_speed (sb_id INT NOT NULL, speed_id INT NOT NULL, INDEX IDX_6F08A71F707F4EA8 (sb_id), INDEX IDX_6F08A71F8F3A8393 (speed_id), PRIMARY KEY(sb_id, speed_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speed (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sb_speed ADD CONSTRAINT FK_6F08A71F707F4EA8 FOREIGN KEY (sb_id) REFERENCES sb (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sb_speed ADD CONSTRAINT FK_6F08A71F8F3A8393 FOREIGN KEY (speed_id) REFERENCES speed (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sb DROP speeds');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sb_speed DROP FOREIGN KEY FK_6F08A71F707F4EA8');
        $this->addSql('ALTER TABLE sb_speed DROP FOREIGN KEY FK_6F08A71F8F3A8393');
        $this->addSql('DROP TABLE sb_speed');
        $this->addSql('DROP TABLE speed');
        $this->addSql('ALTER TABLE sb ADD speeds JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
