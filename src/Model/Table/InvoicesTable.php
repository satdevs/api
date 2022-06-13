<?php
// Baked at 2022.05.06. 10:00:49
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invoices Model
 *
 * @property \App\Model\Table\MyUsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\TemplatesTable&\Cake\ORM\Association\BelongsTo $Templates
 * @property \App\Model\Table\SubsTable&\Cake\ORM\Association\BelongsTo $Subs
 *
 * @method \App\Model\Entity\Invoice newEmptyEntity()
 * @method \App\Model\Entity\Invoice newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invoice findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Invoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InvoicesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('invoices');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
		$this->addBehavior('JeffAdmin.Datepicker');	// inserts only if there is date or time or datetime field

        $this->belongsTo('MyUsers', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Templates', [
            'foreignKey' => 'template_id',
            'joinType' => 'INNER',
        ]);
        //$this->belongsTo('Subs', [
        //    'foreignKey' => 'sub_id',
        //    'joinType' => 'INNER',
        //]);
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
            ->scalar('user_id')
            ->maxLength('user_id', 64)
            //->allowEmptyString('user_id');
			->notEmptyString('user_id');

        $validator
            ->nonNegativeInteger('template_id')
            ->requirePresence('template_id', 'create')
            ->notEmptyString('template_id');

        $validator
            ->scalar('sub_id')
            ->maxLength('sub_id', 20)
            ->requirePresence('sub_id', 'create')
            ->notEmptyString('sub_id');

        $validator
            ->scalar('invoiceNumber')
            ->maxLength('invoiceNumber', 20)
            ->allowEmptyString('invoiceNumber');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 250)
            ->requirePresence('filename', 'create')
            ->notEmptyFile('filename');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('status')
            ->maxLength('status', 45)
            ->allowEmptyString('status');

        $validator
            ->dateTime('sent')
            ->allowEmptyDateTime('sent');

        $validator
            ->scalar('hash')
            ->maxLength('hash', 1000)
            ->allowEmptyString('hash');

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
        $rules->add($rules->isUnique(['id']), ['errorField' => 'id']);
        $rules->add($rules->existsIn(['user_id'], 'MyUsers'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['template_id'], 'Templates'), ['errorField' => 'template_id']);
        //$rules->add($rules->existsIn(['sub_id'], 'Subs'), ['errorField' => 'sub_id']);

        return $rules;
    }
}
