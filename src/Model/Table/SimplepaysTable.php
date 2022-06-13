<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SimplepaysTable extends Table{


    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('simplepays_dev');
        //$this->setTable('simplepays');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

    }


    public function validationDefault(Validator $validator): Validator
    {
        return $validator;
    }


    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['id']), ['errorField' => 'id']);

        return $rules;
    }

    public static function defaultConnectionName(): string
    {
        return 'saghysat';
    }


}
