<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330132424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE specialty_item_source_part DROP FOREIGN KEY FK_2A642247605A4EC1');
        $this->addSql('ALTER TABLE specialty_item_source_part DROP FOREIGN KEY FK_2A64224753CF384');
        $this->addSql('DROP TABLE specialty_item_source_part');
        $this->addSql('ALTER TABLE specialty_item ADD source_part_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE specialty_item ADD CONSTRAINT FK_D53E7D7C53CF384 FOREIGN KEY (source_part_id) REFERENCES source_part (id)');
        $this->addSql('CREATE INDEX IDX_D53E7D7C53CF384 ON specialty_item (source_part_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE specialty_item_source_part (specialty_item_id INT NOT NULL, source_part_id INT NOT NULL, INDEX IDX_2A642247605A4EC1 (specialty_item_id), INDEX IDX_2A64224753CF384 (source_part_id), PRIMARY KEY(specialty_item_id, source_part_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE specialty_item_source_part ADD CONSTRAINT FK_2A642247605A4EC1 FOREIGN KEY (specialty_item_id) REFERENCES specialty_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specialty_item_source_part ADD CONSTRAINT FK_2A64224753CF384 FOREIGN KEY (source_part_id) REFERENCES source_part (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specialty_item DROP FOREIGN KEY FK_D53E7D7C53CF384');
        $this->addSql('DROP INDEX IDX_D53E7D7C53CF384 ON specialty_item');
        $this->addSql('ALTER TABLE specialty_item DROP source_part_id');
    }
}
