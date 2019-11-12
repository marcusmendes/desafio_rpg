<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191108130922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Tabela de relacionamento entre characters e weapons';
    }

    public function up(Schema $schema) : void
    {
        $charactersTable = $schema->getTable('characters');
        $weaponsTable = $schema->getTable('weapons');

        $table = $schema->createTable('character_weapon');
        $table->addColumn('id', 'integer', ['unsigned' => false, 'autoincrement' => true]);
        $table->addColumn('id_character', 'integer');
        $table->addColumn('id_weapon', 'integer');

        $table->addForeignKeyConstraint(
            $charactersTable,
            ['id_character'],
            ['id'],
            ['onDelete' => 'NO ACTION', 'onUpdate' => 'NO ACTION']
        );

        $table->addForeignKeyConstraint(
            $weaponsTable,
            ['id_weapon'],
            ['id'],
            ['onDelete' => 'NO ACTION', 'onUpdate' => 'NO ACTION']
        );

        $table->setPrimaryKey(['id']);
        $table->addIndex(['id_character']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('character_weapon');
    }
}
