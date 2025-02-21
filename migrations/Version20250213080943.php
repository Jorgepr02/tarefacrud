<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250213080943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__historial_viaxes AS SELECT id, lugar_saida, destino, data FROM historial_viaxes');
        $this->addSql('DROP TABLE historial_viaxes');
        $this->addSql('CREATE TABLE historial_viaxes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, transporte VARCHAR(55) NOT NULL, destino VARCHAR(55) NOT NULL, data DATE NOT NULL, duracion INTEGER NOT NULL, motivo VARCHAR(255) DEFAULT NULL, aloxamento VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO historial_viaxes (id, transporte, destino, data) SELECT id, lugar_saida, destino, data FROM __temp__historial_viaxes');
        $this->addSql('DROP TABLE __temp__historial_viaxes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__historial_viaxes AS SELECT id, destino, data, transporte FROM historial_viaxes');
        $this->addSql('DROP TABLE historial_viaxes');
        $this->addSql('CREATE TABLE historial_viaxes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, destino VARCHAR(55) NOT NULL, data DATE NOT NULL, lugar_saida VARCHAR(55) NOT NULL, num_pasaxeiros INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO historial_viaxes (id, destino, data, lugar_saida) SELECT id, destino, data, transporte FROM __temp__historial_viaxes');
        $this->addSql('DROP TABLE __temp__historial_viaxes');
    }
}
