<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompanyMaster Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $CompanyTypesMasters
 * @property \App\Model\Table\CompanyBankMasterTable|\Cake\ORM\Association\HasMany $CompanyBankMaster
 * @property \App\Model\Table\CompanyContactPersonsTable|\Cake\ORM\Association\HasMany $CompanyContactPersons
 * @property \App\Model\Table\CompanyIndustryTypesTable|\Cake\ORM\Association\HasMany $CompanyIndustryTypes
 * @property \App\Model\Table\CompanySublocationTable|\Cake\ORM\Association\HasMany $CompanySublocation
 * @property \App\Model\Table\InquiryTable|\Cake\ORM\Association\HasMany $Inquiry
 * @property \App\Model\Table\MarketingCampaignCompanyTable|\Cake\ORM\Association\HasMany $MarketingCampaignCompany
 * @property \App\Model\Table\SupplierEvaluationRegistrationTableTable|\Cake\ORM\Association\HasMany $SupplierEvaluationRegistrationTable
 *
 * @method \App\Model\Entity\CompanyMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompanyMaster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CompanyMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompanyMaster|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompanyMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyMaster[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompanyMaster findOrCreate($search, callable $callback = null, $options = [])
 */
class CompanyMasterTable extends Table
{
 
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('company_master');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');

//         $this->belongsTo('CompanyTypesMaster', [
//             'foreignKey' => 'company_types_master_id',
//             'joinType' => 'INNER'
//         ]);
       
//         $this->hasMany('CompanyBankMaster', [
//             'foreignKey' => 'company_master_id'
//         ]);

        //commented //
       /*  $this->hasMany('CompanyContactPersons', [
            'foreignKey' => 'company_master_id'
        ]); */
        $this->hasMany('CompanyIndustryTypes', [
            'foreignKey' => 'company_master_id'
        ]);
        
        $this->hasMany('CompanySublocation', [
            'foreignKey' => 'company_master_id'
        ]);
        $this->hasOne('CompanyTypes', [
        		'foreignKey' => 'company_master_id',
        		//'join'=>'left'
        ]);
        
        $this->hasMany('CustomerProductMaster', [
            'foreignKey' => 'company_master_id',
            'join'=>'left'
        ]);
        
//         $this->hasMany('Inquiry', [
//             'foreignKey' => 'company_master_id'
//         ]);
//         $this->hasMany('MarketingCampaignCompany', [
//             'foreignKey' => 'company_master_id'
//         ]);
//         $this->hasMany('SupplierEvaluationRegistrationTable', [
//             'foreignKey' => 'company_master_id'
//         ]);

        
        $this->hasMany('CustomerCreditMaster', [
            'foreignKey' => 'company_master_id',
            'joinType' => 'INNER'
        ])->setBindingKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('Company_name')
            ->requirePresence('Company_name')
            ->notEmpty('Company_name');

        $validator
            ->scalar('company_information')
            ->allowEmpty('company_information');

        $validator
            ->scalar('website_address')
            ->allowEmpty('website_address');

        $validator
            ->scalar('gstin')
            ->allowEmpty('gstin');

        $validator
            ->scalar('pan_number')
            ->allowEmpty('pan_number');


        $validator
            ->allowEmpty('iso');
        
        $validator
            ->scalar('visiting_card')
            ->allowEmpty('visiting_card');
            
        $validator
            ->dateTime('created')
            ->allowEmpty('created');

        $validator
            ->integer('created_by')
            ->allowEmpty('created_by');

        $validator
            ->dateTime('modified')
            ->allowEmpty('modified');

        $validator
            ->integer('modified_by')
            ->allowEmpty('modified_by');
            
        $validator
            ->integer('active')
            ->allowEmpty('active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
//     public function buildRules(RulesChecker $rules)
//     {
//         $rules->add($rules->existsIn(['company_types_master_id'], 'CompanyTypesMaster'));

//         return $rules;
//     }
}
