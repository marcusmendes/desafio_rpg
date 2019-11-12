<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191108130511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Criar tabela de armas';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('weapons');
        $table->addColumn('id', 'integer', ['unsigned' => false, 'autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 100]);
        $table->addColumn('amount_attack', 'integer');
        $table->addColumn('amount_defense', 'integer');
        $table->addColumn('amount_damage', 'integer');
        $table->setPrimaryKey(['id']);
        $table->addIndex(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('weapons');
    }
}
