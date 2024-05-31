<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530060216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sale (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER NOT NULL, seller_id INTEGER NOT NULL, buyer_id INTEGER NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_E54BC00599E6F5DF FOREIGN KEY (player_id) REFERENCES players (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E54BC0058DE820D9 FOREIGN KEY (seller_id) REFERENCES teams (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E54BC0056C755722 FOREIGN KEY (buyer_id) REFERENCES teams (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E54BC00599E6F5DF ON sale (player_id)');
        $this->addSql('CREATE INDEX IDX_E54BC0058DE820D9 ON sale (seller_id)');
        $this->addSql('CREATE INDEX IDX_E54BC0056C755722 ON sale (buyer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sale');
    }
}
