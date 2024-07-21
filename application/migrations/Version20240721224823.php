<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240721224823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added customer and transaction tables.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, balance NUMERIC(15, 2) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, cancelled_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL, description VARCHAR(255) NOT NULL, amount NUMERIC(15, 2) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, cancelled_at DATETIME DEFAULT NULL, source_account_id INT DEFAULT NULL, destination_account_id INT DEFAULT NULL, INDEX IDX_723705D1E7DF2E9E (source_account_id), INDEX IDX_723705D1C652C408 (destination_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C652C408 FOREIGN KEY (destination_account_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
