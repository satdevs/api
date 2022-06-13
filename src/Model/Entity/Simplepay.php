<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Simplepay Entity
 *
 * @property int $id
 * @property string|null $sub_id
 * @property string|null $retEvent
 * @property string|null $ipnStatus
 * @property string|null $winszlaStatus
 * @property string|null $invoiceId
 * @property string|null $invoiceBiz
 * @property \Cake\I18n\FrozenTime|null $invoiceInsertDate
 * @property string|null $invoiceUser
 * @property string|null $ids
 * @property string|null $name
 * @property int|null $amount
 * @property string|null $retResponseCode
 * @property string|null $retTransactionId
 * @property string|null $retMercant
 * @property string|null $retOrderId
 * @property string|null $ipnSalt
 * @property string|null $ipnOrderRef
 * @property string|null $ipnSignature
 * @property string|null $ipnMethod
 * @property string|null $ipnMerchant
 * @property \Cake\I18n\FrozenTime|null $ipnFinishDate
 * @property \Cake\I18n\FrozenTime|null $ipnPaymentDate
 * @property string|null $ipnTransactionId
 * @property \Cake\I18n\FrozenTime|null $ipnReceiveDate
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $city
 * @property string|null $address
 * @property string|null $country
 * @property string|null $email
 * @property string|null $provider
 * @property string|null $provide_id
 * @property string|null $transaction_id
 * @property string|null $request
 * @property string|null $returnData
 * @property bool|null $luhn_ok
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Sub $sub
 * @property \App\Model\Entity\Provide $provide
 * @property \App\Model\Entity\Transaction $transaction
 */
class Simplepay extends Entity{

    protected $_accessible = [
        'sub_id' => true,
        'retEvent' => true,
        'ipnStatus' => true,
        'winszlaStatus' => true,
        'invoiceId' => true,
        'invoiceBiz' => true,
        'invoiceInsertDate' => true,
        'invoiceUser' => true,
        'ids' => true,
        'name' => true,
        'amount' => true,
        'retResponseCode' => true,
        'retTransactionId' => true,
        'retMercant' => true,
        'retOrderId' => true,
        'ipnSalt' => true,
        'ipnOrderRef' => true,
        'ipnSignature' => true,
        'ipnMethod' => true,
        'ipnMerchant' => true,
        'ipnFinishDate' => true,
        'ipnPaymentDate' => true,
        'ipnTransactionId' => true,
        'ipnReceiveDate' => true,
        'state' => true,
        'zip' => true,
        'city' => true,
        'address' => true,
        'country' => true,
        'email' => true,
        'provider' => true,
        'provide_id' => true,
        'transaction_id' => true,
        'request' => true,
        'returnData' => true,
        'luhn_ok' => true,
        'created' => true,
        'modified' => true,
        'sub' => true,
        'provide' => true,
        'transaction' => true
    ];
}
