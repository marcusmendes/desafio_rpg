<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191112225616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Criar tabela rounds';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('rounds');
        $table->addColumn('id', 'integer', ['unsigned' => false, 'autoincrement' => true]);
        $table->addColumn('name', 'string');
        $table->addColumn('round_number', 'integer');
        $table->setPrimaryKey(['id']);
        $table->addIndex(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('rounds');
    }
}
