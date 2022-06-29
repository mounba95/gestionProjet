<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601102933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, projets_id INT DEFAULT NULL, nom_client VARCHAR(255) NOT NULL, prenom_client VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel INT NOT NULL, compagni VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, INDEX IDX_C7440455597A6CB7 (projets_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nom_equipe VARCHAR(255) NOT NULL, emplacement VARCHAR(255) NOT NULL, is_external TINYINT(1) NOT NULL, id_chef_equipe INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE predecesseur (id INT AUTO_INCREMENT NOT NULL, taches_id INT DEFAULT NULL, nom_predecesseur VARCHAR(255) NOT NULL, INDEX IDX_D05BD47EB8A61670 (taches_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, nom_projet VARCHAR(255) NOT NULL, date_debut_projet DATETIME NOT NULL, dat_fin_projet DATETIME NOT NULL, date_debut_reel DATETIME NOT NULL, date_fin_reel DATETIME NOT NULL, projet_complet TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE soustache (id INT AUTO_INCREMENT NOT NULL, taches_id INT DEFAULT NULL, statues_id INT DEFAULT NULL, nom_soutache VARCHAR(255) NOT NULL, pourcentage_achever INT NOT NULL, INDEX IDX_40AF0E22B8A61670 (taches_id), INDEX IDX_40AF0E22BD6AE736 (statues_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, nom_status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, statues_id INT DEFAULT NULL, equipes_id INT DEFAULT NULL, projets_id INT DEFAULT NULL, nom_tache VARCHAR(255) NOT NULL, date_prevue_debut DATETIME NOT NULL, date_prevu_fin DATETIME NOT NULL, date_actuel_debut DATETIME NOT NULL, date_actuel_fin DATETIME NOT NULL, pourcentage_achever INT NOT NULL, INDEX IDX_93872075BD6AE736 (statues_id), INDEX IDX_93872075737800BA (equipes_id), INDEX IDX_93872075597A6CB7 (projets_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_equipe (user_id INT NOT NULL, equipe_id INT NOT NULL, INDEX IDX_411BA128A76ED395 (user_id), INDEX IDX_411BA1286D861B89 (equipe_id), PRIMARY KEY(user_id, equipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455597A6CB7 FOREIGN KEY (projets_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE predecesseur ADD CONSTRAINT FK_D05BD47EB8A61670 FOREIGN KEY (taches_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE soustache ADD CONSTRAINT FK_40AF0E22B8A61670 FOREIGN KEY (taches_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE soustache ADD CONSTRAINT FK_40AF0E22BD6AE736 FOREIGN KEY (statues_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075BD6AE736 FOREIGN KEY (statues_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075737800BA FOREIGN KEY (equipes_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075597A6CB7 FOREIGN KEY (projets_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE user_equipe ADD CONSTRAINT FK_411BA128A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_equipe ADD CONSTRAINT FK_411BA1286D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075737800BA');
        $this->addSql('ALTER TABLE user_equipe DROP FOREIGN KEY FK_411BA1286D861B89');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455597A6CB7');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075597A6CB7');
        $this->addSql('ALTER TABLE soustache DROP FOREIGN KEY FK_40AF0E22BD6AE736');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075BD6AE736');
        $this->addSql('ALTER TABLE predecesseur DROP FOREIGN KEY FK_D05BD47EB8A61670');
        $this->addSql('ALTER TABLE soustache DROP FOREIGN KEY FK_40AF0E22B8A61670');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE predecesseur');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE soustache');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE user_equipe');
    }
}
