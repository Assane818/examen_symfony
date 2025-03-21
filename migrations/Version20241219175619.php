<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219175619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classe (id SERIAL NOT NULL, niveau_id INT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8F87BF96B3E9C81 ON classe (niveau_id)');
        $this->addSql('CREATE TABLE cours (id SERIAL NOT NULL, professeur_id INT NOT NULL, nom VARCHAR(50) NOT NULL, module VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CBAB22EE9 ON cours (professeur_id)');
        $this->addSql('CREATE TABLE niveau (id SERIAL NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE professeur (id SERIAL NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, specialite VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE session (id SERIAL NOT NULL, classe_id INT NOT NULL, cours_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, heure_d TIME(0) WITHOUT TIME ZONE NOT NULL, heure_f TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D044D5D48F5EA509 ON session (classe_id)');
        $this->addSql('CREATE INDEX IDX_D044D5D47ECF78B0 ON session (cours_id)');
        $this->addSql('COMMENT ON COLUMN session.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN session.heure_d IS \'(DC2Type:time_immutable)\'');
        $this->addSql('COMMENT ON COLUMN session.heure_f IS \'(DC2Type:time_immutable)\'');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D48F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D47ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE classe DROP CONSTRAINT FK_8F87BF96B3E9C81');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9CBAB22EE9');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D48F5EA509');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D47ECF78B0');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE session');
    }
}
