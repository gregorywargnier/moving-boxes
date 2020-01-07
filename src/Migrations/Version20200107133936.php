<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200107133936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boxes (id INT AUTO_INCREMENT NOT NULL, moving_id INT NOT NULL, origin_id INT DEFAULT NULL, destination_id INT DEFAULT NULL, number INT NOT NULL, name VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_CDF1B2E9FB5E617D (moving_id), INDEX IDX_CDF1B2E956A273CC (origin_id), INDEX IDX_CDF1B2E9816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movings (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, default_moving_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(45) NOT NULL, lastname VARCHAR(45) NOT NULL, screenname VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E96A3C49DA (default_moving_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_movings (id INT AUTO_INCREMENT NOT NULL, moving_id INT NOT NULL, user_id INT NOT NULL, roles_id INT DEFAULT NULL, INDEX IDX_EFEAAD34FB5E617D (moving_id), INDEX IDX_EFEAAD34A76ED395 (user_id), INDEX IDX_EFEAAD3438C751C4 (roles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7CA11A96A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boxes ADD CONSTRAINT FK_CDF1B2E9FB5E617D FOREIGN KEY (moving_id) REFERENCES movings (id)');
        $this->addSql('ALTER TABLE boxes ADD CONSTRAINT FK_CDF1B2E956A273CC FOREIGN KEY (origin_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE boxes ADD CONSTRAINT FK_CDF1B2E9816C6140 FOREIGN KEY (destination_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E96A3C49DA FOREIGN KEY (default_moving_id) REFERENCES movings (id)');
        $this->addSql('ALTER TABLE users_movings ADD CONSTRAINT FK_EFEAAD34FB5E617D FOREIGN KEY (moving_id) REFERENCES movings (id)');
        $this->addSql('ALTER TABLE users_movings ADD CONSTRAINT FK_EFEAAD34A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_movings ADD CONSTRAINT FK_EFEAAD3438C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT FK_7CA11A96A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_movings DROP FOREIGN KEY FK_EFEAAD3438C751C4');
        $this->addSql('ALTER TABLE boxes DROP FOREIGN KEY FK_CDF1B2E9FB5E617D');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E96A3C49DA');
        $this->addSql('ALTER TABLE users_movings DROP FOREIGN KEY FK_EFEAAD34FB5E617D');
        $this->addSql('ALTER TABLE users_movings DROP FOREIGN KEY FK_EFEAAD34A76ED395');
        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY FK_7CA11A96A76ED395');
        $this->addSql('ALTER TABLE boxes DROP FOREIGN KEY FK_CDF1B2E956A273CC');
        $this->addSql('ALTER TABLE boxes DROP FOREIGN KEY FK_CDF1B2E9816C6140');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE boxes');
        $this->addSql('DROP TABLE movings');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_movings');
        $this->addSql('DROP TABLE rooms');
    }
}
