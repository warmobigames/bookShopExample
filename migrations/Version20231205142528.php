<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205142528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE genre (id INT NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genre_book (genre_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(genre_id, book_id))');
        $this->addSql('CREATE INDEX IDX_70087AC14296D31F ON genre_book (genre_id)');
        $this->addSql('CREATE INDEX IDX_70087AC116A2B381 ON genre_book (book_id)');
        $this->addSql('ALTER TABLE genre_book ADD CONSTRAINT FK_70087AC14296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE genre_book ADD CONSTRAINT FK_70087AC116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE genre_id_seq CASCADE');
        $this->addSql('ALTER TABLE genre_book DROP CONSTRAINT FK_70087AC14296D31F');
        $this->addSql('ALTER TABLE genre_book DROP CONSTRAINT FK_70087AC116A2B381');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE genre_book');
    }
}
