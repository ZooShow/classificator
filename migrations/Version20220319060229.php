<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319060229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // типы жанров
        $this->addSql('INSERT INTO sign_type (id, name) VALUES (1, "Размерная");');
        $this->addSql('INSERT INTO sign_type (id, name) VALUES (2, "Скалярная");');
        $this->addSql('INSERT INTO sign_type (id, name) VALUES (3, "Логическая");');
        // жанры
        $this->addSql('INSERT INTO genre (id, name) VALUES (1, "Рассказ");');
        $this->addSql('INSERT INTO genre (id, name) VALUES (2, "Новелла");');
        $this->addSql('INSERT INTO genre (id, name) VALUES (3, "Эссе");');
        $this->addSql('INSERT INTO genre (id, name) VALUES (4, "Притча");');
        $this->addSql('INSERT INTO genre (id, name) VALUES (5, "Басня");');
        $this->addSql('INSERT INTO genre (id, name) VALUES (6, "Очерк");');
        $this->addSql('INSERT INTO genre (id, name) VALUES (7, "Биография");');
        $this->addSql('INSERT INTO genre (id, name) VALUES (8, "Повесть");');
        $this->addSql('INSERT INTO genre (id, name) VALUES (9, "Роман");');
        $this->addSql('INSERT INTO genre (id, name) VALUES (10, "Роман-эпопея");');
        // признаки
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (1, "Объем произведения", 2);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (2, "Количество централььных персонажей", 1);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (3, "Время действия", 2);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (4, "Количестов проблем, поднимаемых в произведении", 1);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (5, "Последовательность повествования", 2);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (6, "Существование прототипов героев в реальной жизни", 3);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (7, "Насыщенность сюжета", 2);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (8, "Скоротечность сюжета", 2);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (9, "Наличие неожиданной развязки", 3);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (10, "Наличие четкой авторской позиции", 3);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (11, "Возможность сопоставления сюжета с реальной жизнью", 3);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (12, "Наличие морали", 3);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (13, "Объяснение морали автором", 3);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (14, "Развитость описательного изображения", 3);');
        $this->addSql('INSERT INTO sign (id, name, sign_type_id) VALUES (15, "Элементы документального произведения", 3);');
        // значения признаков
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (1, 1,"Небольшой");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (2, 1,"Средний");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (3, 1,"Большой");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (4, 2, "1");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (5, 2, "> 1");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (6, 3, "Переломная историческая эпоха");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (7, 3, "Не переломная историческая эпоха");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (8, 4, "1");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (9, 4, "> 1");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (10, 5, "Последовательное");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (11, 5, "Рваное");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (12, 6, "Да");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (13, 6, "Нет");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (14, 7, "Насыщенный событиями");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (15, 7, "Ненасыщенный событиями");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (16, 8, "Размеренный");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (17, 8, "Скоротечный");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (18, 9, "Да");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (19, 9, "Нет");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (20, 10, "Да");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (21, 10, "Нет");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (22, 11, "Да");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (23, 11, "Нет");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (24, 12, "Да");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (25, 12, "Нет");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (26, 13, "Да");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (27, 13, "Нет");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (28, 14, "Да");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (29, 14, "Нет");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (30, 15, "Да");');
        $this->addSql('INSERT INTO sign_bind (id, sign_id, value) VALUES (31, 15, "Нет");');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
