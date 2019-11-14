<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113215833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Adicionar campo dice_faces na tabela characters';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('characters');
        $table->addColumn('dice_faces', 'integer');
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('characters');
        $table->dropColumn('dice_faces');
    }
}
