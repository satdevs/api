<?php
// Baked at 2022.05.09. 08:04:33
declare(strict_types=1);

namespace App\Controller\Apidev;

use App\Controller\Apidev\AppController;

use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * Simplepays Controller
 *
 * @method \App\Model\Entity\Simplepay[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SimplepaysController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

	}

    /**
     * Index method
     *
	 * @param string|null $param: if($param !== null && $param == 'clear-filter')...
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($param = null)
    {
		//Configure::write('debug', false);
		Configure::write('debug', true);

		$pays = $this->Simplepays->find('all', ['order' => ['Simplepays.id' => 'asc']])
			->select(['id', 'ids', 'retResponseCode', 'sub_id', 'name', 'amount', 'ipnSalt', 'transaction_id', 'created', 'winszlaStatus', 'retEvent', 'invoiceId', 'invoiceBiz', 'invoiceInsertDate', 'invoiceUser'])
			->where([
				//'retEvent' => "SUCCESS",
				'ipnStatus' => "FINISHED",
				'winszlaStatus' => "NEW"
			]); //->first();

        $this->set('pays', $pays);	// $this->paginate()
        $this->viewBuilder()->setOption('serialize', 'pays');

	}


	/*
		Lekéri az új befizetéseket, amiket XML-ben visszaada a számlázó programnak.
		A lista alapján a számlázó befizetéseket hozhat létre és a befizetések után visszajelez ide,
		hogy a WinSzlaStatus mezőt átírja: simplePay() fg.
	*/
    public function simplepays($hash = null) {
		Configure::write('debug', false);
		Configure::write('debug', true);

		$this->autoRender = false;

		//die( $hash );

		$decoded_hash = base64_decode( $hash );

		//debug($decoded_hash);

		if(empty($hash) || $decoded_hash != date("Y-m-d") . $this->salt){
			die();
		}

		//echo $this->salt;

		//$this->loadModel('Simplepays');
		$pays = $this->Simplepays->find()
			->select(['id', 'ipnPaymentDate', 'sub_id', 'name', 'amount', 'transaction_id', 'ipnSalt'])
			->where([
				//'retEvent' => "SUCCESS",
				'ipnStatus' => "FINISHED",
				'winszlaStatus' => "NEW"
			])
			->order(['Simplepays.id' => 'asc']);

		//debug($pays->toArray());

		$items = $pays->toArray();
		$i = 0;
		foreach($items as $pay){
			$items[$i++]['ipnPaymentDate'] = Time::parse($pay['ipnPaymentDate'])->i18nFormat('yyyy.MM.dd. HH:mm');
		}

		//debug($items);
		//debug($pays->toArray());

        $this->set('item', $items);
        $this->viewBuilder()->setOption('serialize', 'item');

		die();

    }


	/*
		Egy simplePay rekord kezelése
		GET-tel meghívva simán csak lekérdez információkat.
		POST-tal megíhvva pedig módosítja a rekordot, azaz az invoices befizetését igazolja vissza.
	*/
    public function simplepay($invoiceBiz=Null, $hash=Null) {
		Configure::write('debug', false);

		$decoded_hash 	= '';
		$conditions 	= ['id' => 0];
		$message 		= '-';

		//$this->loadModel('Simplepays');
		$simplepaysTable = TableRegistry::get('Simplepays');

		if ($this->request->is(['get']) && $invoiceBiz !== Null && $hash !== Null) {

			$decoded_hash = base64_decode( $hash );

			if(empty($hash) || $decoded_hash != date("Y-m-d") . $this->salt){
				die();
			}

		}

		if($invoiceBiz !== Null){
			$conditions = ['invoiceBiz' => $invoiceBiz];
		}

		if(isset($this->request->data['orderRef'])){
			$conditions = ['id' => $this->request->data['orderRef']];
		}

		$simplepay = $this->Simplepays->find()->where($conditions)->first();

		if($simplepay === null){
			$message = "MISSING RECORD";
		}

		// ------ set the status --------
		if ($this->request->is(['post'])) {
			$decoded_hash = base64_decode( $this->request->data['hash'] );

			if(substr($decoded_hash, 0, 10) == date("Y-m-d") && substr($decoded_hash, 10) == $simplepay->ipnSalt){

				if($simplepay !== null){
					if($this->request->data['invoiceId'] != null && $this->request->data['invoiceBiz'] != null && $this->request->data['invoiceUser'] != null){
						$simplepay->winszlaStatus 		= 'PAID';
						$simplepay->invoiceId 			= $this->request->data['invoiceId'];
						$simplepay->invoiceBiz 			= $this->request->data['invoiceBiz'];
						$simplepay->invoiceUser			= $this->request->data['invoiceUser'];
						$simplepay->invoiceInsertDate 	= date('Y-m-d H:i:s');
						if($simplepaysTable->save($simplepay)){

							//------- Új SimplePay befizetés bekönyverlése invoice-ba --------
							$email = new Email();
							$email->viewBuilder()->setLayout('default', 'default');
							$email->setTransport('saghysat');
							$email->setEmailFormat('html');
							$email->setFrom(['info@saghysat.hu' => 'Sághy-Sat Kft.']);
							$email->setReplyTo(['info@saghysat.hu' => 'Sághy-Sat Kft.']);
							$email->setTo('zsolt@saghysat.hu');
							$email->setSubject('Új SimplePay befizetés: ' . $simplepay->invoiceBiz . ', SubID: ' . $simplepay->sub_id);
							$body = 'Új SimplePay befizetés: ' . $simplepay->invoiceBiz . "<br>\nSubID: " . $simplepay->sub_id;
							$email->send($body);
							//------- /.Új SimplePay befizetés bekönyverlése invoice-ba --------

							$message = 'SAVED';
						}else{
							$message = 'HAS BEEN NOT SAVED';
						}
					}
				}

			}else{
				$message = 'HASH-ERROR';
			}

		} // POST

		$this->set('simplepay', $simplepay);
		$this->set('message', $message);

    }
}

