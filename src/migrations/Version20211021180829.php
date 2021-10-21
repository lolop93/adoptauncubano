<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021180829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_attributes ADD nacionalidad VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_attributes ADD fecha_nac DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_attributes ADD ojos VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_attributes ADD profesion VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_attributes ADD ciudad VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_attributes ADD altura INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_attributes ADD peso INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_attributes ADD gustos TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_attributes ADD sexo VARCHAR(255) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN user_attributes.gustos IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_attributes DROP nacionalidad');
        $this->addSql('ALTER TABLE user_attributes DROP fecha_nac');
        $this->addSql('ALTER TABLE user_attributes DROP ojos');
        $this->addSql('ALTER TABLE user_attributes DROP profesion');
        $this->addSql('ALTER TABLE user_attributes DROP ciudad');
        $this->addSql('ALTER TABLE user_attributes DROP altura');
        $this->addSql('ALTER TABLE user_attributes DROP peso');
        $this->addSql('ALTER TABLE user_attributes DROP gustos');
        $this->addSql('ALTER TABLE user_attributes DROP sexo');
    }
}
