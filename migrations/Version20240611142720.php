<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611142720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Organization][Event] Create ManyToMany relationship.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE organization_event (organization_id INTEGER NOT NULL, event_id INTEGER NOT NULL, PRIMARY KEY(organization_id, event_id), CONSTRAINT FK_B529EC6032C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B529EC6071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B529EC6032C8A3DE ON organization_event (organization_id)');
        $this->addSql('CREATE INDEX IDX_B529EC6071F7E88B ON organization_event (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE organization_event');
    }
}
