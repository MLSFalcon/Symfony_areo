<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250507091305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE conges ADD ref_pilote_id INT NOT NULL, ADD ref_validation_admin_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conges ADD CONSTRAINT FK_6327DE3A864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conges ADD CONSTRAINT FK_6327DE3AF50CD755 FOREIGN KEY (ref_validation_admin_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6327DE3A864AABAC ON conges (ref_pilote_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6327DE3AF50CD755 ON conges (ref_validation_admin_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3A864AABAC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conges DROP FOREIGN KEY FK_6327DE3AF50CD755
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6327DE3A864AABAC ON conges
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6327DE3AF50CD755 ON conges
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conges DROP ref_pilote_id, DROP ref_validation_admin_id
        SQL);
    }
}
