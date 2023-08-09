<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806165840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_company (id UUID NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, image_urls TEXT DEFAULT NULL, enabled BOOLEAN NOT NULL, currency VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, timezone VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, optional_features JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6FED1398989D9B62 ON company_company (slug)');
        $this->addSql('CREATE INDEX IDX_6FED1398989D9B62 ON company_company (slug)');
        $this->addSql('COMMENT ON COLUMN company_company.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN company_company.image_urls IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE security_user ADD company_ids TEXT NULL');
        $this->addSql('COMMENT ON COLUMN security_user.company_ids IS \'(DC2Type:simple_array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE company_company');
        $this->addSql('ALTER TABLE security_user DROP company_ids');
    }
}
