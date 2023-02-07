<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207154000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE irrigation ADD air_condition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE irrigation ADD CONSTRAINT FK_BAE1AE089987C5BA FOREIGN KEY (air_condition_id) REFERENCES air_condition (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BAE1AE089987C5BA ON irrigation (air_condition_id)');
        $this->addSql('ALTER TABLE preference CHANGE plant_id plant_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE irrigation DROP FOREIGN KEY FK_BAE1AE089987C5BA');
        $this->addSql('DROP INDEX UNIQ_BAE1AE089987C5BA ON irrigation');
        $this->addSql('ALTER TABLE irrigation DROP air_condition_id');
        $this->addSql('ALTER TABLE preference CHANGE plant_id plant_id INT NOT NULL');
    }
}
