<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200704152354 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE certification_report (id INT AUTO_INCREMENT NOT NULL, remodeling_id INT NOT NULL, report VARCHAR(255) NOT NULL, builder_signature TINYINT(1) DEFAULT \'0\', architect_signature TINYINT(1) DEFAULT \'0\', technical_architect_signature TINYINT(1) DEFAULT \'0\', finished TINYINT(1) DEFAULT \'0\', check_order SMALLINT NOT NULL, INDEX IDX_22076E333D1B0C57 (remodeling_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certification_report ADD CONSTRAINT FK_22076E333D1B0C57 FOREIGN KEY (remodeling_id) REFERENCES remodeling (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE certification_report');
    }
}
