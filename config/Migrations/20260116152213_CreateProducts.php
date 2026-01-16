<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateProducts extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('products');

        $table
            ->addColumn('title', 'string', [
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'null' => false,
            ])
            ->addColumn('price', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'limit' => 50,
                'null' => false,
                'default' => 'active',
            ])
            ->addColumn('image', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('user_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'null' => false,
            ])

            // Índices
            ->addIndex(['user_id'])

            // Clave foránea
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'NO_ACTION',
                ]
            )

            ->create();
    }
}

