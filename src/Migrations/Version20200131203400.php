<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200131203400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_game (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, games_id INT NOT NULL, INDEX IDX_59AA7D4567B3B43D (users_id), INDEX IDX_59AA7D4597FFC673 (games_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_slide (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, caption VARCHAR(255) NOT NULL, INDEX IDX_40DC97EDE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nick_name VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, short_description VARCHAR(255) DEFAULT NULL, long_description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, hash VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, short_description VARCHAR(255) DEFAULT NULL, long_description LONGTEXT DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, game_book_id INT NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, short_description VARCHAR(255) DEFAULT NULL, long_description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, next_game_at DATETIME DEFAULT NULL, owner INT NOT NULL, INDEX IDX_232B318C8360CCAE (game_book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_note (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, icon VARCHAR(255) DEFAULT NULL, INDEX IDX_24A89638E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_book (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, cover_image VARCHAR(255) DEFAULT NULL, short_description VARCHAR(255) DEFAULT NULL, long_description LONGTEXT DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, INDEX IDX_20F0CF1D12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D4567B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D4597FFC673 FOREIGN KEY (games_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_slide ADD CONSTRAINT FK_40DC97EDE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C8360CCAE FOREIGN KEY (game_book_id) REFERENCES game_book (id)');
        $this->addSql('ALTER TABLE game_note ADD CONSTRAINT FK_24A89638E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_book ADD CONSTRAINT FK_20F0CF1D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D4567B3B43D');
        $this->addSql('ALTER TABLE game_book DROP FOREIGN KEY FK_20F0CF1D12469DE2');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D4597FFC673');
        $this->addSql('ALTER TABLE game_slide DROP FOREIGN KEY FK_40DC97EDE48FD905');
        $this->addSql('ALTER TABLE game_note DROP FOREIGN KEY FK_24A89638E48FD905');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C8360CCAE');
        $this->addSql('DROP TABLE user_game');
        $this->addSql('DROP TABLE game_slide');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_note');
        $this->addSql('DROP TABLE game_book');
    }
}
