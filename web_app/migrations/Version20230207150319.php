<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207150319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE air_condition ADD area_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE air_condition ADD CONSTRAINT FK_DC64B9DABD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('CREATE INDEX IDX_DC64B9DABD0F409C ON air_condition (area_id)');
        $this->addSql('ALTER TABLE irrigation ADD plant_id INT DEFAULT NULL, ADD area_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE irrigation ADD CONSTRAINT FK_BAE1AE081D935652 FOREIGN KEY (plant_id) REFERENCES plant (id)');
        $this->addSql('ALTER TABLE irrigation ADD CONSTRAINT FK_BAE1AE08BD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('CREATE INDEX IDX_BAE1AE081D935652 ON irrigation (plant_id)');
        $this->addSql('CREATE INDEX IDX_BAE1AE08BD0F409C ON irrigation (area_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE air_condition DROP FOREIGN KEY FK_DC64B9DABD0F409C');
        $this->addSql('DROP INDEX IDX_DC64B9DABD0F409C ON air_condition');
        $this->addSql('ALTER TABLE air_condition DROP area_id');
        $this->addSql('ALTER TABLE irrigation DROP FOREIGN KEY FK_BAE1AE081D935652');
        $this->addSql('ALTER TABLE irrigation DROP FOREIGN KEY FK_BAE1AE08BD0F409C');
        $this->addSql('DROP INDEX IDX_BAE1AE081D935652 ON irrigation');
        $this->addSql('DROP INDEX IDX_BAE1AE08BD0F409C ON irrigation');
        $this->addSql('ALTER TABLE irrigation DROP plant_id, DROP area_id');
    }
}
