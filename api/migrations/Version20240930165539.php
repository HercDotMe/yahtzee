<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930165539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_7249979CBEA95C75BBAB1D7A ON user_provider');
        $this->addSql('CREATE INDEX IDX_7249979C57367132BBAB1D7A ON user_provider (provider_user_id, provider_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_7249979C57367132BBAB1D7A ON user_provider');
        $this->addSql('CREATE INDEX IDX_7249979CBEA95C75BBAB1D7A ON user_provider (token_value, provider_name)');
    }
}
