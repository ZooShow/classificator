<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301043027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sign ADD sign_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE sign ADD CONSTRAINT FK_9F7E91FE7024CA6E FOREIGN KEY (sign_type_id) REFERENCES sign_type (id)');
        $this->addSql('CREATE INDEX IDX_9F7E91FE7024CA6E ON sign (sign_type_id)');
        $this->addSql('ALTER TABLE sign_type DROP FOREIGN KEY FK_8BB59C406FC7C15');
        $this->addSql('DROP INDEX IDX_8BB59C406FC7C15 ON sign_type');
        $this->addSql('ALTER TABLE sign_type DROP sign_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genre CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sign DROP FOREIGN KEY FK_9F7E91FE7024CA6E');
        $this->addSql('DROP INDEX IDX_9F7E91FE7024CA6E ON sign');
        $this->addSql('ALTER TABLE sign DROP sign_type_id, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sign_bind CHANGE value value VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sign_type ADD sign_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sign_type ADD CONSTRAINT FK_8BB59C406FC7C15 FOREIGN KEY (sign_id) REFERENCES sign (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8BB59C406FC7C15 ON sign_type (sign_id)');
    }
}
