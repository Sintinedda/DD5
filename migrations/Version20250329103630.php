<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329103630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `classe_tools` (classe_id INT NOT NULL, item_subcategory_id INT NOT NULL, INDEX IDX_A38D8A4F8F5EA509 (classe_id), INDEX IDX_A38D8A4F4C2B59A3 (item_subcategory_id), PRIMARY KEY(classe_id, item_subcategory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `classe_tools` ADD CONSTRAINT FK_A38D8A4F8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `classe_tools` ADD CONSTRAINT FK_A38D8A4F4C2B59A3 FOREIGN KEY (item_subcategory_id) REFERENCES item_subcategory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96568477C4');
        $this->addSql('DROP INDEX IDX_8F87BF96568477C4 ON classe');
        $this->addSql('ALTER TABLE classe ADD gold VARCHAR(10) DEFAULT NULL, DROP tool2_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `classe_tools` DROP FOREIGN KEY FK_A38D8A4F8F5EA509');
        $this->addSql('ALTER TABLE `classe_tools` DROP FOREIGN KEY FK_A38D8A4F4C2B59A3');
        $this->addSql('DROP TABLE `classe_tools`');
        $this->addSql('ALTER TABLE classe ADD tool2_id INT DEFAULT NULL, DROP gold');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96568477C4 FOREIGN KEY (tool2_id) REFERENCES item_category (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96568477C4 ON classe (tool2_id)');
    }
}
