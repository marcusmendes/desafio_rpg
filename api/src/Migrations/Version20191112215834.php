<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191112215834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Adicionar coluna unique_id na tabela weapons';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('weapons');
        $table->addColumn('unique_id', 'string', ['unique' => true]);
        $table->addIndex(['unique_id']);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('weapons');
        $table->dropColumn('unique_id');
    }
}
