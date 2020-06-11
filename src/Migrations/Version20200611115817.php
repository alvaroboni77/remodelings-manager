<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200611115817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE architect (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE builder (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remodeling (id INT AUTO_INCREMENT NOT NULL, builder_id INT NOT NULL, architect_id INT NOT NULL, technical_architect_id INT NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, built_area INT NOT NULL, start_date DATE NOT NULL, construction_time INT NOT NULL, type VARCHAR(100) NOT NULL, INDEX IDX_ED3BCFE9959F66E4 (builder_id), INDEX IDX_ED3BCFE99F7266C0 (architect_id), INDEX IDX_ED3BCFE978A8FE5C (technical_architect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technical_architect (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE remodeling ADD CONSTRAINT FK_ED3BCFE9959F66E4 FOREIGN KEY (builder_id) REFERENCES builder (id)');
        $this->addSql('ALTER TABLE remodeling ADD CONSTRAINT FK_ED3BCFE99F7266C0 FOREIGN KEY (architect_id) REFERENCES architect (id)');
        $this->addSql('ALTER TABLE remodeling ADD CONSTRAINT FK_ED3BCFE978A8FE5C FOREIGN KEY (technical_architect_id) REFERENCES technical_architect (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE remodeling DROP FOREIGN KEY FK_ED3BCFE99F7266C0');
        $this->addSql('ALTER TABLE remodeling DROP FOREIGN KEY FK_ED3BCFE9959F66E4');
        $this->addSql('ALTER TABLE remodeling DROP FOREIGN KEY FK_ED3BCFE978A8FE5C');
        $this->addSql('DROP TABLE architect');
        $this->addSql('DROP TABLE builder');
        $this->addSql('DROP TABLE remodeling');
        $this->addSql('DROP TABLE technical_architect');
    }
}
