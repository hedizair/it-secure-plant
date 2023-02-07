<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207145157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE preference (id INT AUTO_INCREMENT NOT NULL, plant_id INT NOT NULL, area_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_5D69B0531D935652 (plant_id), UNIQUE INDEX UNIQ_5D69B053BD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B0531D935652 FOREIGN KEY (plant_id) REFERENCES plant (id)');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053BD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE area CHANGE information information VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B0531D935652');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053BD0F409C');
        $this->addSql('DROP TABLE preference');
        $this->addSql('ALTER TABLE area CHANGE information information VARCHAR(255) NOT NULL');
    }
}
