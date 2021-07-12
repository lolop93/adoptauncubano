<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712174008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE galeria_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_attributes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE galeria (id INT NOT NULL, foto_perfil VARCHAR(255) DEFAULT NULL, galeria TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN galeria.galeria IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE user_attributes (id INT NOT NULL, es_cubano BOOLEAN NOT NULL, color_pelo VARCHAR(40) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE galeria_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_attributes_id_seq CASCADE');
        $this->addSql('DROP TABLE galeria');
        $this->addSql('DROP TABLE user_attributes');
    }
}
