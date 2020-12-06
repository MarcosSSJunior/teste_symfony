<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205225213 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE membros (idprojeto BIGINT NOT NULL, idpessoa BIGINT NOT NULL, INDEX IDX_A3A50B167F51CFFA (idprojeto), INDEX IDX_A3A50B167862062E (idpessoa), PRIMARY KEY(idprojeto, idpessoa)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pessoa (id BIGINT AUTO_INCREMENT NOT NULL, nome VARCHAR(100) NOT NULL, datanascimento DATE DEFAULT NULL, cpf VARCHAR(14) DEFAULT NULL, funcionario TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projeto (id BIGINT AUTO_INCREMENT NOT NULL, idgerente BIGINT NOT NULL, nome VARCHAR(200) NOT NULL, data_inicio DATE DEFAULT NULL, data_previsao_fim DATE DEFAULT NULL, data_fim DATE DEFAULT NULL, descricao LONGTEXT DEFAULT NULL, status VARCHAR(45) DEFAULT NULL, orcamento DOUBLE PRECISION DEFAULT NULL, risco VARCHAR(45) DEFAULT NULL, INDEX IDX_A0559D94EF681A03 (idgerente), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membros ADD CONSTRAINT FK_A3A50B167F51CFFA FOREIGN KEY (idprojeto) REFERENCES projeto (id)');
        $this->addSql('ALTER TABLE membros ADD CONSTRAINT FK_A3A50B167862062E FOREIGN KEY (idpessoa) REFERENCES pessoa (id)');
        $this->addSql('ALTER TABLE projeto ADD CONSTRAINT FK_A0559D94EF681A03 FOREIGN KEY (idgerente) REFERENCES pessoa (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membros DROP FOREIGN KEY FK_A3A50B167862062E');
        $this->addSql('ALTER TABLE projeto DROP FOREIGN KEY FK_A0559D94EF681A03');
        $this->addSql('ALTER TABLE membros DROP FOREIGN KEY FK_A3A50B167F51CFFA');
        $this->addSql('DROP TABLE membros');
        $this->addSql('DROP TABLE pessoa');
        $this->addSql('DROP TABLE projeto');
    }
}
