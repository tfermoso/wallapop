<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Purchases Model
 *
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Buyers
 *
 * @method \App\Model\Entity\Purchase newEmptyEntity()
 * @method \App\Model\Entity\Purchase newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Purchase> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Purchase get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Purchase findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Purchase patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Purchase> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Purchase|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Purchase saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Purchase>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Purchase>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Purchase>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Purchase> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Purchase>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Purchase>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Purchase>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Purchase> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PurchasesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('purchases');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Buyers', [
            'foreignKey' => 'buyer_id',
            'className' => 'Users',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('product_id')
            ->notEmptyString('product_id')
            ->add('product_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('buyer_id')
            ->notEmptyString('buyer_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['product_id']), ['errorField' => 'product_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);
        $rules->add($rules->existsIn(['buyer_id'], 'Buyers'), ['errorField' => 'buyer_id']);

        return $rules;
    }
}
