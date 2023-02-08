<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230208111441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, exposure VARCHAR(255) NOT NULL, information VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE air_condition ADD area_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE air_condition ADD CONSTRAINT FK_DC64B9DABD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('CREATE INDEX IDX_DC64B9DABD0F409C ON air_condition (area_id)');
        $this->addSql('ALTER TABLE irrigation ADD plant_id INT DEFAULT NULL, ADD area_id INT DEFAULT NULL, ADD air_condition_id INT DEFAULT NULL, CHANGE watering_start_date watering_start_date DATETIME NOT NULL, CHANGE watering_end_date watering_end_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE irrigation ADD CONSTRAINT FK_BAE1AE081D935652 FOREIGN KEY (plant_id) REFERENCES plant (id)');
        $this->addSql('ALTER TABLE irrigation ADD CONSTRAINT FK_BAE1AE08BD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE irrigation ADD CONSTRAINT FK_BAE1AE089987C5BA FOREIGN KEY (air_condition_id) REFERENCES air_condition (id)');
        $this->addSql('CREATE INDEX IDX_BAE1AE081D935652 ON irrigation (plant_id)');
        $this->addSql('CREATE INDEX IDX_BAE1AE08BD0F409C ON irrigation (area_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BAE1AE089987C5BA ON irrigation (air_condition_id)');
        $this->addSql('ALTER TABLE preference ADD ip VARCHAR(255) NOT NULL, CHANGE plant_id plant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053BD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE water_level ADD date DATETIME NOT NULL, DROP threshold');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE air_condition DROP FOREIGN KEY FK_DC64B9DABD0F409C');
        $this->addSql('ALTER TABLE irrigation DROP FOREIGN KEY FK_BAE1AE08BD0F409C');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053BD0F409C');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP INDEX IDX_DC64B9DABD0F409C ON air_condition');
        $this->addSql('ALTER TABLE air_condition DROP area_id');
        $this->addSql('ALTER TABLE irrigation DROP FOREIGN KEY FK_BAE1AE081D935652');
        $this->addSql('ALTER TABLE irrigation DROP FOREIGN KEY FK_BAE1AE089987C5BA');
        $this->addSql('DROP INDEX IDX_BAE1AE081D935652 ON irrigation');
        $this->addSql('DROP INDEX IDX_BAE1AE08BD0F409C ON irrigation');
        $this->addSql('DROP INDEX UNIQ_BAE1AE089987C5BA ON irrigation');
        $this->addSql('ALTER TABLE irrigation DROP plant_id, DROP area_id, DROP air_condition_id, CHANGE watering_start_date watering_start_date DATE NOT NULL, CHANGE watering_end_date watering_end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE preference DROP ip, CHANGE plant_id plant_id INT NOT NULL');
        $this->addSql('ALTER TABLE water_level ADD threshold DOUBLE PRECISION NOT NULL, DROP date');
    }
}
