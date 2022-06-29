<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601214511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet CHANGE date_debut_projet date_debut_projet DATETIME DEFAULT NULL, CHANGE dat_fin_projet dat_fin_projet DATETIME DEFAULT NULL, CHANGE date_debut_reel date_debut_reel DATETIME DEFAULT NULL, CHANGE date_fin_reel date_fin_reel DATETIME DEFAULT NULL, CHANGE projet_complet projet_complet INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet CHANGE date_debut_projet date_debut_projet DATETIME NOT NULL, CHANGE dat_fin_projet dat_fin_projet DATETIME NOT NULL, CHANGE date_debut_reel date_debut_reel DATETIME NOT NULL, CHANGE date_fin_reel date_fin_reel DATETIME NOT NULL, CHANGE projet_complet projet_complet TINYINT(1) NOT NULL');
    }
}
