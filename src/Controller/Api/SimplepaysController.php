<?php
// Baked at 2022.05.09. 08:04:33
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Mailer\Email;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;
//use Cake\Http\Cookie\CookieCollection;
use Cake\Http\Cookie\Cookie;
use Cake\Utility\Security;
use DateTime;


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
        //$this->loadComponent('Security');

    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

/*
		$csrfToken = $this->request->getAttribute('csrfToken');

		// Add a cookie
		$this->response = $this->response->withCookie(Cookie::create(
			'myCsrfToken',
			$csrfToken,
			// All keys are optional
			[
				'expires' => new DateTime('+1 year'),
				'path' => '',
				'domain' => '',
				'secure' => false,
				'http' => false,
			]
		));
*/

/*

		$this->myCsrfToken = $this->cookies->get('myCsrfToken')->getValue();

		$csrfToken = $this->request->getAttribute('csrfToken');

		$cookie = (new Cookie('myCsrfToken'))
			->withValue($csrfToken)
			->withExpiry(new FrozenTime('+20 days'))
			->withPath('/')
			->withSecure(false)
			->withHttpOnly(true);

		$cookies = new CookieCollection([$cookie]);

		//if(!$this->cookies->has('myCsrfToken')) {
			$cookie = (new Cookie('myCsrfToken'))
				->withValue($csrfToken)
				->withExpiry(new \DateTime('+20 days'))
				->withPath('/')
				->withSecure(false)
				->withHttpOnly(true);
			$this->cookies = new CookieCollection([$cookie]);
		//}

		$this->myCsrfToken = $this->cookies->get('myCsrfToken')->getValue();
*/
	}

    public function test() {
		$this->autoRender = false;

		if(!$this->request->is(['post'])){

		}

		if($this->request->is(['post'])){

			file_put_contents(LOGS . 'request.log', 'csrfToken: ' . $this->request->getAttribute('csrfToken') . "\n", FILE_APPEND);
			file_put_contents(LOGS . 'request.log', 'HEADERS: ' . print_r(getallheaders(), true) . "\n", FILE_APPEND);

			file_put_contents(LOGS . 'request.log', 'DATA: ' . print_r($this->request->getData(), true) . "\n", FILE_APPEND);

			//$data = json_decode($this->request->getData()['data']);
			//print_r($data);
		}

		//debug( $this->cookies->getCookies() );

		echo $this->request->getAttribute('csrfToken');

		//die("");

	}



	/*
		Egy simplePay rekord kezelése
		GET-tel meghívva simán csak lekérdez információkat.
		POST-tal megíhvva pedig módosítja a rekordot, azaz az invoices befizetését igazolja vissza.
	*/
	// https://ao-system.net/en/note/107
	// Állapotkódok: https://hu.wikipedia.org/wiki/HTTP-%C3%A1llapotk%C3%B3dok
    public function simplepay($invoiceBiz=Null, $hash=Null) {
		Configure::write('debug', false);
		Configure::write('debug', true);

		$decoded_hash 	= null;
		$simplepay 		= null;
		$message 		= null;
		$response		= null;
		$conditions 	= ['id' => 0];	// , 'winszlaStatus' => 'NEW'

		// Itt csak a hash dátumellenőrzése
		if($this->request->is(['get'])){

			if($hash == null){
				$response = $this->response->withStatus(403);
				return $response;
				die();
			}

			$decoded_hash 	= base64_decode( $hash );

			//if(empty($hash) || substr($decoded_hash, 0, 10) != date("Y-m-d")){
			if(empty($hash) || $decoded_hash != date("Y-m-d") . $this->salt ){
				$response = $this->response->withStatus(403);
				return $response;
				die();
			}

			// Rekord lekérése
			if($invoiceBiz != '0'){

				$this->loadModel('Simplepays');
				$simplepay = $this->Simplepays->find()->select(['id', 'amount', 'invoiceId', 'invoiceBiz', 'invoiceUser', 'ipnSalt', 'winszlaStatus'])->where(['invoiceBiz' => $invoiceBiz])->first();

				if($simplepay != null){
					// visszaadni a befizetés adatait, hash-t még ellenőrizni

					//if( !(substr($decoded_hash, 0, 10) == date("Y-m-d") && substr($decoded_hash, 10, strlen($simplepay->ipnSalt)) == $simplepay->ipnSalt && substr($decoded_hash, strlen($simplepay->ipnSalt) + 10) == $this->salt) ){
					//if( !(substr($decoded_hash, 0, 10) == date("Y-m-d") && substr($decoded_hash, 10) == $this->salt) ){
					if( $decoded_hash != date("Y-m-d") . $this->salt ){
						$response = $this->response->withStatus(403);
						return $response;
						die();
					}
				}else{
					$response = $this->response->withStatus(403);
					return $response;
					die();
				}
			}else{
				$simplepay['response'] = 'NOT OK';
			}

			$this->set('simplepay', $simplepay);
			$this->viewBuilder()->setOption('serialize', 'simplepay');
			$this->RequestHandler->renderAs($this, 'json');

			//$response = $this->response->withStatus(404);
			//return $response;
			//die();

		}

		//file_put_contents(WWW_ROOT . 'files' . DS . 'request.log', print_r($this->request, true) . "\n", FILE_APPEND);

		if($this->request->is(['post'])){

			$data = json_decode($this->request->getData()['data']);
			//$content = "01."; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
			$decoded_hash 	= base64_decode( $data->hash );
			//$content = "02."; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
			if(empty($data->hash) || $decoded_hash != date("Y-m-d") . $this->salt ){
				$response = $this->response->withStatus(403);
				return $response;
				die();
			}
			//$content = "03."; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
			if(isset($data->orderRef)){
				$conditions['id'] = $data->orderRef;
			}
			//$content = "04."; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);

			//file_put_contents(WWW_ROOT . 'files' . DS . 'data.log',
			//	print_r($data, true) .
			//	"\n-----------------------------------\n",
			//FILE_APPEND);

			// Rekord lekérése
			$this->loadModel('Simplepays');
			$simplepay = $this->Simplepays
				->find()
				->select([
					'id', 'invoiceId', 'invoiceBiz', 'invoiceUser', 'ipnSalt', 'winszlaStatus', 'ipnTransactionId'
				])
				->where($conditions)
				->first();

			//$content = print_r($simplepay, true); file_put_contents(WWW_ROOT . 'files' . DS . 'request.log', $content . "\n", FILE_APPEND);

			if($simplepay !== null){

				//$content = "1."; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
				//$content = "1. $data->ipnSalt: " . $data->ipnSalt . "; $data->ipnTransactionId: " . $data->ipnTransactionId; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
				//$content = "1. $simplepay->ipnSalt: " . $simplepay->ipnSalt . "; $simplepay->ipnTransactionId: " . $simplepay->ipnTransactionId; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
				//$content = "------------------"; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
				if($data->ipnSalt !== null && $data->ipnTransactionId !== null){
					//$content = "2."; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
					if($simplepay->ipnSalt == $data->ipnSalt && $simplepay->ipnTransactionId == $data->ipnTransactionId){
						//$content = "3."; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
						if($simplepay->winszlaStatus == 'PAID'){
							//$content = "HAS BEEN PAID"; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
							$response = [
								'response' 			=> 'HAS BEEN PAID!',
								'id' 				=> 0,
								'winszlaStatus' 	=> $simplepay->winszlaStatus
							];
						}else{
							if($simplepay->winszlaStatus == 'NEW'){

								// HASH ellenőrizve és jó
								$recData = [];

								$record = $this->Simplepays->get($simplepay->id);
								$recData['id'] 					= $record->id;
								$recData['invoiceId'] 			= $data->invoiceId;
								$recData['invoiceBiz'] 			= $data->invoiceBiz;
								$recData['invoiceUser'] 		= $data->invoiceUser;
								$recData['invoiceInsertDate'] 	= date('Y-m-d H:i:s');
								$recData['winszlaStatus'] 		= 'PAID';
								$record = $this->Simplepays->patchEntity($record, $recData);

								if($this->Simplepays->save($record)){
									//$content = "SAVE OK"; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
									/*
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
									*/
									$response = [
										'response' 			=> 'OK',
										'id' 				=> $record->id,
										'subId'				=> $record->sub_id,
										'ipnTransactionId' 	=> $record->ipnTransactionId,
										'invoiceId' 		=> $record->invoiceId,
										'invoiceBiz' 		=> $record->invoiceBiz,
										'winszlaStatus' 	=> $record->winszlaStatus
									];
								}else{
									//$content = "SAVE NOT OK"; file_put_contents(ROOT . DS . 'logs' . DS . 'request.log', $content . "\n", FILE_APPEND);
									$response = [
										'response' 			=> 'COULD NOT SAVE!',
										'id' 				=> 0,
										'winszlaStatus' 	=> $record->winszlaStatus
									];
								}
							}else{
								$response = [
									'response' 			=> 'THIS RECORD STATUS IS ' . $simplepay->winszlaStatus,
									'id' 				=> 0,
									'winszlaStatus' 	=> $simplepay->winszlaStatus
								];
							}
						}
						echo json_encode($response);
						die();

					}else{
						$response = [
							'response' 			=> 'Different ipnSalt and ipnTransactionId',
							'id' 				=> 0,
							'winszlaStatus' 	=> $simplepay->winszlaStatus
						];
						echo json_encode($response);
						// Different ipnSalt and ipnTransactionId
						//echo "Different ipnSalt and ipnTransactionId";
						$response = $this->response->withStatus(403);	// 403 - nincs jogosultság: A kliensnek nincs jogosultsága megtekinteni az oldalt.
						return $response;
						die();
					}

				}else{
					$response = [
						'response' 			=> 'MISSING ipnSalt',
						'id' 				=> 0,
						'winszlaStatus' 	=> $simplepay->winszlaStatus
					];
					echo json_encode($response);
					// MISSING ipnSalt
					//echo "MISSING ipnSalt";
					$response = $this->response->withStatus(403);	// 403 - nincs jogosultság: A kliensnek nincs jogosultsága megtekinteni az oldalt.
					return $response;
					die();
				}

			}else{
				$response = [
					'response' 			=> 'MISSING record',
					'id' 				=> 0,
					'winszlaStatus' 	=> $simplepay->winszlaStatus
				];
				echo json_encode($response);
				// MISSING record
				//echo "MISSING record";
				$response = $this->response->withStatus(403);	// 403 - nincs jogosultság: A kliensnek nincs jogosultsága megtekinteni az oldalt.
				return $response;
				die();
			}

		}

	}


	/*
		Lekéri az új befizetéseket, amiket XML-ben visszaada a számlázó programnak.
		A lista alapján a számlázó befizetéseket hozhat létre és a befizetések után visszajelez ide,
		hogy a WinSzlaStatus mezőt átírja: simplePay() fg.
	*/
    public function simplepays($hash = null)
	{
		Configure::write('debug', false);
		//Configure::write('debug', true);

		//die( $hash );

		$decoded_hash = base64_decode( $hash );


		//if(empty($hash) || $decoded_hash != date("Y-m-d") . $this->salt){
		//	// Állapotkódok: https://hu.wikipedia.org/wiki/HTTP-%C3%A1llapotk%C3%B3dok
		//	$response = $this->response->withStatus(403);	// 403 - nincs jogosultság: A kliensnek nincs jogosultsága megtekinteni az oldalt.
		//	return $response;
		//	die();
		//}

		//$this->loadModel('Simplepays');
		$pays = $this->Simplepays->find()
			->select(['id', 'sub_id', 'ipnPaymentDate', 'name', 'amount', 'transaction_id', 'ipnSalt'])
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

//		file_put_contents(WWW_ROOT . 'files' . DS . 'dump.log',
//			print_r($items, true) .
//			"\n-----------------------------------\n",
//		FILE_APPEND);

        $this->set('item', $items);
        $this->viewBuilder()->setOption('serialize', 'item');
		$this->RequestHandler->renderAs($this, 'json');

		//$response = $this->response->withStatus(400);
		//return $response;

		// * * * Ticketingből * * *
		//if (!move_uploaded_file($fileTmp, $fileWithPath)) {
		//		$response = $this->response->withStatus(403);
		//		$message='No ok';
		//		$this->set(compact('message'));
		//		$this->set('_serialize', ['message']);
		//		$this->RequestHandler->renderAs($this, 'json');
		//		return;
		//}

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


/*
			if(null !== $pays){
				debug($pays->toArray());

				$i = 1;
				foreach($pays as $pay){
					echo $i++ . ". " . $pay->created . " - " . $pay->name . "; <b>" . $pay->amount . "</b> Ft.<br>";
				}

			}else{
				echo "Nincs új rekord";
			}
*/


			//$this->layout ='ajax';
			//$this->render('sitemap.xml');


/*
			$email = new Email();
			$email->viewBuilder()->setLayout('default', 'default');
			$email->setTransport('saghysat');
			$email->setEmailFormat('html');
			$email->setFrom(['info@saghysat.hu' => 'Sághy-Sat Kft.']);
			$email->setReplyTo(['info@saghysat.hu' => 'Sághy-Sat Kft.']);
			$email->setTo('zsolt@saghysat.hu');
			$email->setSubject('Új SimplePay befizetés: 12345');
			$body = "Új SimplePay befizetés: 112233<br>\nSubID: 223344";
			$email->send($body);
*/


			//die('<hr>* * * teszt * * *');
	}



	// TESZT TESZT TESZT TESZT TESZT TESZT TESZT TESZT TESZT TESZT TESZT
    public function weathers()
	{

		$url = 'https://www.foreca.hu/Hungary/Baranya/B%C3%B3ly/10-day-forecast';

		$data = [];
		$forecast10days = [];

		$page = file_get_contents($url);

		echo $page;
		die();

	}




}

