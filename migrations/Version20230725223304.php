<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725223304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affaire (id INT AUTO_INCREMENT NOT NULL, responsable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, compte_c6 VARCHAR(255) NOT NULL, phase VARCHAR(255) DEFAULT NULL, journalaffiare VARCHAR(1000) DEFAULT NULL, date_de_debut DATE NOT NULL, date_de_fin DATE DEFAULT NULL, echeance DATE DEFAULT NULL, INDEX IDX_9C3F18EF53C59D72 (responsable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE affaire_user (affaire_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1D5CEE97F082E755 (affaire_id), INDEX IDX_1D5CEE97A76ED395 (user_id), PRIMARY KEY(affaire_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE affaire_section (affaire_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_B620019FF082E755 (affaire_id), INDEX IDX_B620019FD823E37A (section_id), PRIMARY KEY(affaire_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, responsable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2D737AEF53C59D72 (responsable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affaire ADD CONSTRAINT FK_9C3F18EF53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE affaire_user ADD CONSTRAINT FK_1D5CEE97F082E755 FOREIGN KEY (affaire_id) REFERENCES affaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE affaire_user ADD CONSTRAINT FK_1D5CEE97A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE affaire_section ADD CONSTRAINT FK_B620019FF082E755 FOREIGN KEY (affaire_id) REFERENCES affaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE affaire_section ADD CONSTRAINT FK_B620019FD823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affaire DROP FOREIGN KEY FK_9C3F18EF53C59D72');
        $this->addSql('ALTER TABLE affaire_user DROP FOREIGN KEY FK_1D5CEE97F082E755');
        $this->addSql('ALTER TABLE affaire_user DROP FOREIGN KEY FK_1D5CEE97A76ED395');
        $this->addSql('ALTER TABLE affaire_section DROP FOREIGN KEY FK_B620019FF082E755');
        $this->addSql('ALTER TABLE affaire_section DROP FOREIGN KEY FK_B620019FD823E37A');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF53C59D72');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D823E37A');
        $this->addSql('DROP TABLE affaire');
        $this->addSql('DROP TABLE affaire_user');
        $this->addSql('DROP TABLE affaire_section');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
