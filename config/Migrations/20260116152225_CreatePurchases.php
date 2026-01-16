<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreatePurchases extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('purchases');
        $table
            ->addColumn('product_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('buyer_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'null' => false,
            ])

            // Índices
            ->addIndex(['product_id'], ['unique' => true])
            ->addIndex(['buyer_id'])

            // Claves foráneas
            ->addForeignKey(
                'product_id',
                'products',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'buyer_id',
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
