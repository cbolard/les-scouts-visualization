<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531091849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ws_branche (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ws_federation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ws_groupe_unite (id INT AUTO_INCREMENT NOT NULL, federation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_C1666BAC6A03EFC5 (federation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ws_membre (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_C2FFEF15D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ws_section (id INT AUTO_INCREMENT NOT NULL, unite_id INT DEFAULT NULL, branche_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_2284D7CEC4A74AB (unite_id), INDEX IDX_2284D7C9DDF9A9E (branche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ws_unite (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_38A901717A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ws_groupe_unite ADD CONSTRAINT FK_C1666BAC6A03EFC5 FOREIGN KEY (federation_id) REFERENCES ws_federation (id)');
        $this->addSql('ALTER TABLE ws_membre ADD CONSTRAINT FK_C2FFEF15D823E37A FOREIGN KEY (section_id) REFERENCES ws_section (id)');
        $this->addSql('ALTER TABLE ws_section ADD CONSTRAINT FK_2284D7CEC4A74AB FOREIGN KEY (unite_id) REFERENCES ws_unite (id)');
        $this->addSql('ALTER TABLE ws_section ADD CONSTRAINT FK_2284D7C9DDF9A9E FOREIGN KEY (branche_id) REFERENCES ws_branche (id)');
        $this->addSql('ALTER TABLE ws_unite ADD CONSTRAINT FK_38A901717A45358C FOREIGN KEY (groupe_id) REFERENCES ws_groupe_unite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ws_groupe_unite DROP FOREIGN KEY FK_C1666BAC6A03EFC5');
        $this->addSql('ALTER TABLE ws_membre DROP FOREIGN KEY FK_C2FFEF15D823E37A');
        $this->addSql('ALTER TABLE ws_section DROP FOREIGN KEY FK_2284D7CEC4A74AB');
        $this->addSql('ALTER TABLE ws_section DROP FOREIGN KEY FK_2284D7C9DDF9A9E');
        $this->addSql('ALTER TABLE ws_unite DROP FOREIGN KEY FK_38A901717A45358C');
        $this->addSql('DROP TABLE ws_branche');
        $this->addSql('DROP TABLE ws_federation');
        $this->addSql('DROP TABLE ws_groupe_unite');
        $this->addSql('DROP TABLE ws_membre');
        $this->addSql('DROP TABLE ws_section');
        $this->addSql('DROP TABLE ws_unite');
    }
}
