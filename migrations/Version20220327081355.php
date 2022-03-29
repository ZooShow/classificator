<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327081355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // рассказ
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (1, 1, 1);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (2, 4, 1);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (3, 8, 1);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (4, 10, 1);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (5, 16, 1);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (6, 18, 1);');
        // новелла
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (7, 1, 2);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (8, 4, 2);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (9, 8, 2);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (10, 10, 2);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (11, 14, 2);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (12, 17, 2);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (13, 18, 2);');
        // эссе
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (14, 1, 3);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (15, 4, 3);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (16, 8, 3);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (17, 8, 3);');
        // притча
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (18, 1, 4);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (19, 8, 4);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (20, 20, 4);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (21, 22, 4);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (22, 24, 4);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (23, 26, 4);');
        // басня
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (24, 1, 5);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (25, 8, 5);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (26, 20, 5);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (27, 23, 5);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (28, 24, 5);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (29, 26, 5);');
        // очерк
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (30, 1, 6);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (31, 4, 6);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (32, 8, 6);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (33, 10, 6);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (34, 16, 6);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (35, 19, 6);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (36, 28, 6);');
        // биография
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (37, 4, 7);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (38, 12, 7);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (39, 30, 7);');
        // повесть
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (40, 2, 8);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (41, 3, 8);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (42, 5, 8);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (43, 9, 8);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (44, 10, 8);');
        // роман
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (45, 3, 9);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (46, 5, 9);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (47, 7, 9);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (48, 9, 9);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (49, 10, 9);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (50, 11, 9);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (51, 14, 9);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (52, 28, 9);');
        // роман-эпопея
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (53, 3, 10);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (54, 5, 10);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (55, 6, 10);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (56, 9, 10);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (57, 10, 10);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (58, 11, 10);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (59, 12, 10);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (60, 14, 10);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (61, 28, 10);');
        $this->addSql('INSERT INTO genre_sign_bind (id, sign_bind_id, genre_id) VALUES (62, 30, 10);');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
