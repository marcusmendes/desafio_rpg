<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113223922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Criar tabela turn_rounds';
    }

    public function up(Schema $schema) : void
    {
        $rounds = $schema->getTable('rounds');
        $character = $schema->getTable('characters');

        $table = $schema->createTable('turn_rounds');
        $table->addColumn('id', 'integer', ['unsigned' => false, 'autoincrement' => true]);
        $table->addColumn('id_round', 'integer');
        $table->addColumn('id_character_striker', 'integer');
        $table->addColumn('id_character_defender', 'integer');
        $table->addColumn('type', 'string');
        $table->addColumn('amount_life_striker', 'integer', ['notnull' => false]);
        $table->addColumn('amount_life_defender', 'integer', ['notnull' => false]);
        $table->addColumn('damage', 'integer', ['notnull' => false]);

        $table->addForeignKeyConstraint(
            $rounds,
            ['id_round'],
            ['id'],
            ['onDelete' => 'NO ACTION', 'onUpdate' => 'NO ACTION']
        );

        $table->addForeignKeyConstraint(
            $character,
            ['id_character_striker'],
            ['id'],
            ['onDelete' => 'NO ACTION', 'onUpdate' => 'NO ACTION']
        );

        $table->addForeignKeyConstraint(
            $character,
            ['id_character_defender'],
            ['id'],
            ['onDelete' => 'NO ACTION', 'onUpdate' => 'NO ACTION']
        );

        $table->setPrimaryKey(['id']);
        $table->addIndex(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('turn_rounds');
    }
}
