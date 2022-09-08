<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220802211254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE boissontaille');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boissontaille (id INT AUTO_INCREMENT NOT NULL, boisson_id INT DEFAULT NULL, taille_id INT DEFAULT NULL, lignecommande_id INT DEFAULT NULL, quantite_stock INT DEFAULT NULL, INDEX IDX_D1041CEC20D3031 (lignecommande_id), INDEX IDX_D1041CEC734B8089 (boisson_id), INDEX IDX_D1041CECFF25611A (taille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE boissontaille ADD CONSTRAINT FK_D1041CEC20D3031 FOREIGN KEY (lignecommande_id) REFERENCES lignecommande (id)');
        $this->addSql('ALTER TABLE boissontaille ADD CONSTRAINT FK_D1041CECFF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('ALTER TABLE boissontaille ADD CONSTRAINT FK_D1041CEC734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
    }
}
