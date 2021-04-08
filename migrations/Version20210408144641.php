<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408144641 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9474526C4B89032C');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, user_id, post_id, content FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, post_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, user_id, post_id, content) SELECT id, user_id, post_id, content FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8D14D45BBE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, autor_id, image FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, autor_id INTEGER NOT NULL, image VARCHAR(255) NOT NULL COLLATE BINARY, post_at DATETIME NOT NULL, CONSTRAINT FK_5A8A6C8D14D45BBE FOREIGN KEY (autor_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, autor_id, image) SELECT id, autor_id, image FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D14D45BBE ON post (autor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526C4B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, user_id, post_id, content FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, post_id INTEGER NOT NULL, content CLOB NOT NULL)');
        $this->addSql('INSERT INTO comment (id, user_id, post_id, content) SELECT id, user_id, post_id, content FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8D14D45BBE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, autor_id, image FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, autor_id INTEGER NOT NULL, image VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO post (id, autor_id, image) SELECT id, autor_id, image FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D14D45BBE ON post (autor_id)');
    }
}
