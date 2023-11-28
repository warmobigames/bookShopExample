<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128005426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE chapter_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chapter (id INT NOT NULL, book_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, text TEXT NOT NULL, comment_before TEXT NOT NULL, comment_after TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F981B52E16A2B381 ON chapter (book_id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE chapter_id_seq CASCADE');
        $this->addSql('ALTER TABLE chapter DROP CONSTRAINT FK_F981B52E16A2B381');
        $this->addSql('DROP TABLE chapter');
    }
}
