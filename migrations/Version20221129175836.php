<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221129175836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD image_file VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE massage CHANGE photo photo_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE image_name image_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP image_file');
        $this->addSql('ALTER TABLE massage CHANGE photo_name photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
    }
}
