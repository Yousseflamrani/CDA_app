<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version202309031135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add section_id to user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD section_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_USER_SECTION FOREIGN KEY (section_id) REFERENCES section(id)');
        $this->addSql('CREATE INDEX IDX_USER_SECTION ON user(section_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_USER_SECTION');
        $this->addSql('DROP INDEX IDX_USER_SECTION ON user');
        $this->addSql('ALTER TABLE user DROP section_id');
    }
}
