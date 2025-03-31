<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329143927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subskill ADD classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subskill ADD CONSTRAINT FK_248E0BAD8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_248E0BAD8F5EA509 ON subskill (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subskill DROP FOREIGN KEY FK_248E0BAD8F5EA509');
        $this->addSql('DROP INDEX IDX_248E0BAD8F5EA509 ON subskill');
        $this->addSql('ALTER TABLE subskill DROP classe_id');
    }
}
