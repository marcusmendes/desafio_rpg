<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191108114835 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Criar a tabela de personagens';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('characters');
        $table->addColumn('id', 'integer', ['unsigned' => false, 'autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => '100']);
        $table->addColumn('amount_life', 'integer');
        $table->addColumn('amount_strength', 'integer');
        $table->addColumn('amount_agility', 'integer');
        $table->setPrimaryKey(['id']);
        $table->addIndex(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('characters');
    }
}
