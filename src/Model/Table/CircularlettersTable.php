<?php
// Baked at 2022.05.09. 13:17:08
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Circularletters Model
 *
 * @property \App\Model\Table\TemplatesTable&\Cake\ORM\Association\BelongsTo $Templates
 *
 * @method \App\Model\Entity\Circularletter newEmptyEntity()
 * @method \App\Model\Entity\Circularletter newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Circularletter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Circularletter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Circularletter findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Circularletter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Circularletter[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Circularletter|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Circularletter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Circularletter[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Circularletter[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Circularletter[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Circularletter[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CircularlettersTable extends Table
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

        $this->setTable('circularletters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Templates', [
            'foreignKey' => 'template_id',
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
            ->nonNegativeInteger('template_id')
            ->allowEmptyString('template_id');

        $validator
            ->scalar('sub_id')
            ->maxLength('sub_id', 10)
            ->allowEmptyString('sub_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 200)
            ->allowEmptyString('name');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('tipus')
            ->maxLength('tipus', 20)
            ->allowEmptyString('tipus');

        $validator
            ->scalar('link')
            ->maxLength('link', 1000)
            ->allowEmptyString('link');

        $validator
            ->scalar('tmp')
            ->maxLength('tmp', 1000)
            ->allowEmptyString('tmp');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->allowEmptyString('status');

        $validator
            ->dateTime('sent')
            ->allowEmptyDateTime('sent');

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
        $rules->add($rules->existsIn(['template_id'], 'Templates'), ['errorField' => 'template_id']);

        return $rules;
    }
}
