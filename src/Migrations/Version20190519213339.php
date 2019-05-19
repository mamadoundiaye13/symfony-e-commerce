<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190519213339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, prix INT NOT NULL, quantite INT NOT NULL, id_user INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_articles (panier_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_2598381AF77D927C (panier_id), INDEX IDX_2598381A1EBAF6CC (articles_id), PRIMARY KEY(panier_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier_articles ADD CONSTRAINT FK_2598381AF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_articles ADD CONSTRAINT FK_2598381A1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE panier_articles DROP FOREIGN KEY FK_2598381AF77D927C');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_articles');
    }
}
