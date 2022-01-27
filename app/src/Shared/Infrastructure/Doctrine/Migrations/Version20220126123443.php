<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220126123443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables for events and user entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('

        CREATE TABLE events (
            id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\',
            aggregate_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\',
            event_type VARCHAR(255) NOT NULL,
            payload LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\',
            occurred_on DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            PRIMARY KEY(id)
        )
        DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB

        ');
        $this->addSql('

        CREATE TABLE users (
            id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\',
            email VARCHAR(255) NOT NULL,
            hashed_password VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        )
        DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB

        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE users');
    }
}
