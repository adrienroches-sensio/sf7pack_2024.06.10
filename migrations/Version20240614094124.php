<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240614094124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Event] Add created by field.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, project_id, name, description, accessible, prerequisites, start_at, end_at FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, project_id INTEGER DEFAULT NULL, created_by_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, accessible BOOLEAN NOT NULL, prerequisites CLOB DEFAULT NULL, start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_3BAE0AA7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3BAE0AA7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, project_id, name, description, accessible, prerequisites, start_at, end_at) SELECT id, project_id, name, description, accessible, prerequisites, start_at, end_at FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7166D1F9C ON event (project_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7B03A8386 ON event (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, project_id, name, description, accessible, prerequisites, start_at, end_at FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, project_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, accessible BOOLEAN NOT NULL, prerequisites CLOB DEFAULT NULL, start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_3BAE0AA7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, project_id, name, description, accessible, prerequisites, start_at, end_at) SELECT id, project_id, name, description, accessible, prerequisites, start_at, end_at FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7166D1F9C ON event (project_id)');
    }
}
