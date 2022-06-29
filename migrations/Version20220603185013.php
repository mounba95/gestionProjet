<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220603185013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache CHANGE date_prevu_fin date_prevu_fin DATETIME DEFAULT NULL, CHANGE date_actuel_debut date_actuel_debut DATETIME DEFAULT NULL, CHANGE date_actuel_fin date_actuel_fin DATETIME DEFAULT NULL, CHANGE pourcentage_achever pourcentage_achever INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache CHANGE date_prevu_fin date_prevu_fin DATETIME NOT NULL, CHANGE date_actuel_debut date_actuel_debut DATETIME NOT NULL, CHANGE date_actuel_fin date_actuel_fin DATETIME NOT NULL, CHANGE pourcentage_achever pourcentage_achever INT NOT NULL');
    }
}
