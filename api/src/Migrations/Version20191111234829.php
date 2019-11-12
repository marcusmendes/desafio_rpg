<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191111234829 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Adicionar nova coluna na tabela characters';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('characters');
        $table->addColumn('unique_id', 'integer', ['unique' => true]);
        $table->addIndex(['unique_id']);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('characters');
        $table->dropColumn('unique_id');
    }
}
