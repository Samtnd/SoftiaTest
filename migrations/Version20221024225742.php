<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024225742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attestation (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, convention_id INT NOT NULL, message LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_326EC63FDDEAB1A3 (etudiant_id), UNIQUE INDEX UNIQ_326EC63FA2ACEBCC (convention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE convention (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, nb_heur INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, convention_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, INDEX IDX_717E22E3A2ACEBCC (convention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63FA2ACEBCC FOREIGN KEY (convention_id) REFERENCES convention (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3A2ACEBCC FOREIGN KEY (convention_id) REFERENCES convention (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attestation DROP FOREIGN KEY FK_326EC63FDDEAB1A3');
        $this->addSql('ALTER TABLE attestation DROP FOREIGN KEY FK_326EC63FA2ACEBCC');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3A2ACEBCC');
        $this->addSql('DROP TABLE attestation');
        $this->addSql('DROP TABLE convention');
        $this->addSql('DROP TABLE etudiant');
    }
}
