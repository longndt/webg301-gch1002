<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220606013616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, sclass_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, duration INT NOT NULL, INDEX IDX_169E6FB9A0053FC7 (sclass_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecturer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dateofbirth DATE NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecturer_course (lecturer_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_BB9AACE9BA2D8762 (lecturer_id), INDEX IDX_BB9AACE9591CC992 (course_id), PRIMARY KEY(lecturer_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sclass (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9A0053FC7 FOREIGN KEY (sclass_id) REFERENCES sclass (id)');
        $this->addSql('ALTER TABLE lecturer_course ADD CONSTRAINT FK_BB9AACE9BA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lecturer_course ADD CONSTRAINT FK_BB9AACE9591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lecturer_course DROP FOREIGN KEY FK_BB9AACE9591CC992');
        $this->addSql('ALTER TABLE lecturer_course DROP FOREIGN KEY FK_BB9AACE9BA2D8762');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9A0053FC7');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE lecturer');
        $this->addSql('DROP TABLE lecturer_course');
        $this->addSql('DROP TABLE sclass');
    }
}
