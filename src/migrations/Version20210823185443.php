<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210823185443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE conversaciones_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE conversaciones (id INT NOT NULL, emisor_id INT NOT NULL, remitente_id INT NOT NULL, fecha TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D33DD86E6BDF87DF ON conversaciones (emisor_id)');
        $this->addSql('CREATE INDEX IDX_D33DD86E1C3E945F ON conversaciones (remitente_id)');
        $this->addSql('ALTER TABLE conversaciones ADD CONSTRAINT FK_D33DD86E6BDF87DF FOREIGN KEY (emisor_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE conversaciones ADD CONSTRAINT FK_D33DD86E1C3E945F FOREIGN KEY (remitente_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE conversaciones_id_seq CASCADE');
        $this->addSql('DROP TABLE conversaciones');
    }
}
