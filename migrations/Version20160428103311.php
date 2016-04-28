<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160428103311 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE User (id CHAR(36) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE EnforcementRequest (id CHAR(36) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE BookAmount (isbn VARCHAR(255) NOT NULL, amount INTEGER NOT NULL, libraryId VARCHAR(255) NOT NULL, PRIMARY KEY(libraryId, isbn))');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE EnforcementRequest');
        $this->addSql('DROP TABLE BookAmount');
    }
}
