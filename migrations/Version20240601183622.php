<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601183622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE connector DROP CONSTRAINT fk_148c456e34d723c9');
        $this->addSql('DROP INDEX idx_148c456e34d723c9');
        $this->addSql('ALTER TABLE connector RENAME COLUMN charging_station_id TO chargingstation_id');
        $this->addSql('ALTER TABLE connector ADD CONSTRAINT FK_148C456EDC9DA675 FOREIGN KEY (chargingstation_id) REFERENCES chargingstation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_148C456EDC9DA675 ON connector (chargingstation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE connector DROP CONSTRAINT FK_148C456EDC9DA675');
        $this->addSql('DROP INDEX IDX_148C456EDC9DA675');
        $this->addSql('ALTER TABLE connector RENAME COLUMN chargingstation_id TO charging_station_id');
        $this->addSql('ALTER TABLE connector ADD CONSTRAINT fk_148c456e34d723c9 FOREIGN KEY (charging_station_id) REFERENCES chargingstation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_148c456e34d723c9 ON connector (charging_station_id)');
    }
}
