<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203104924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE irrigation (id INT AUTO_INCREMENT NOT NULL, watering_start_date DATE NOT NULL, watering_end_date DATE DEFAULT NULL, duration DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, scientific_name VARCHAR(255) NOT NULL, flowering_period VARCHAR(255) NOT NULL, flower_color VARCHAR(255) NOT NULL, foliage VARCHAR(255) NOT NULL, hardiness VARCHAR(255) NOT NULL, exposure VARCHAR(255) NOT NULL, ground_information VARCHAR(255) NOT NULL, humidity VARCHAR(255) NOT NULL, planting_period VARCHAR(255) NOT NULL, multiplication_method VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE water_level (id INT AUTO_INCREMENT NOT NULL, level DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE irrigation');
        $this->addSql('DROP TABLE plant');
        $this->addSql('DROP TABLE water_level');
    }
}
