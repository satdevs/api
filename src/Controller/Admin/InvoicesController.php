<?php
// Baked at 2022.05.06. 10:07:52
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 * @method \App\Model\Entity\Invoice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InvoicesController extends AppController
{

    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
		$this->set('title', __('Invoices'));

	}

    /**
     * Index method
     *
	 * @param string|null $param: if($param !== null && $param == 'clear-filter')...
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($param = null)
    {
		$search = null;
		$invoices = null;

		$this->set('title', __('Invoices'));

		//$this->config['index_number_of_rows'] = 10;
		if($this->config['index_number_of_rows'] === null){
			$this->config['index_number_of_rows'] = 20;
		}

		// Clear filter from session
		if($param !== null && $param == 'clear-filter'){
			$this->session->delete('Layout.' . $this->controller . '.Search');
			$this->redirect( $this->request->referer() );
		}

        $this->paginate = [
            'contain' => ['MyUsers', 'Templates'],
			'conditions' => [
				//'Invoices.name' 		=> 1,
				//'Invoices.visible' 		=> 1,
				'Invoices.status' 		=> 'new',
				//'Invoices.created >= ' 	=> new \DateTime('-10 days'),
				//'Invoices.modified >= '	=> new \DateTime('-10 days'),
			],
			/*
			// Nem tanácsos az order-t itt használni, mert pl az edit után az utolsó  ordert ugyan beálíltja, de
			// kiegészíti ezzel s így az utoljára mentett rekord nem lesz megtalálható az X-edik oldalon, mert az az elsőre kerül.
			// A felhasználó állítson be rendezettséget magának! Kivételes esetek persze lehetnek!
			*/
			'order' => [
				//'Invoices.id' 			=> 'desc',
				//'Invoices.name' 		=> 'asc',
				//'Invoices.visible' 		=> 'desc',
				//'Invoices.pos' 			=> 'desc',
				//'Invoices.rank' 		=> 'asc',
				//'Invoices.created' 		=> 'desc',
				//'Invoices.modified' 	=> 'desc',
			],
			'limit' => $this->config['index_number_of_rows'],
			'maxLimit' => $this->config['index_number_of_rows'],
			//'sortableFields' => ['id', 'name', 'created', '...'],
			//'paramType' => 'querystring',
			//'fields' => ['Invoices.id', 'Invoices.name', ...],
			//'finder' => 'published',
        ];

		//$this->paging = $this->session->read('Layout.' . $this->controller . '.Paging');

		if( $this->paging === null){
			$this->paginate['order'] = [
				//'Invoices.id' 			=> 'desc',
				//'Invoices.name' 		=> 'asc',
				//'Invoices.visible' 		=> 'desc',
				//'Invoices.pos' 			=> 'desc',
				//'Invoices.rank' 		=> 'asc',
				//'Invoices.created' 		=> 'desc',
				//'Invoices.modified' 	=> 'desc',
			];
		}else{
			if($this->request->getQuery('sort') === null && $this->request->getQuery('direction') === null){
				$this->paginate['order'] = [
					// If not in URL-ben, then come from sessinon...
					$this->paging['Invoices']['sort'] => $this->paging['Invoices']['direction']
				];
			}
		}

		if($this->request->getQuery('page') === null && !isset($this->paging['Invoices']['page']) ){
			$this->paginate['page'] = 1;
		}else{
			$this->paginate['page'] = (isset($this->paging['Invoices']['page'])) ? $this->paging['Invoices']['page'] : 1;
		}

		// -- Filter --
		if ($this->request->is('post') || $this->session->read('Layout.' . $this->controller . '.Search') !== null && $this->session->read('Layout.' . $this->controller . '.Search') !== []) {

			$this->paginate['conditions'] = [];

			if( $this->request->is('post') ){
				$search = $this->request->getData();
				$this->session->write('Layout.' . $this->controller . '.Search', $search);
				if($search !== null && $search['s'] !== null && $search['s'] == ''){
					$this->session->delete('Layout.' . $this->controller . '.Search');
					return $this->redirect([
						'controller' => $this->controller,
						'action' => 'index',
						//'?' => [			// Not tested!!!
						//	'page'		=> $this->paging['Invoices']['page'], 	// Vagy 1
						//	'sort'		=> $this->paging['Invoices']['sort'],
						//	'direction'	=> $this->paging['Invoices']['direction'],
						//]
					]);
				}
			}else{
				if($this->session->check('Layout.' . $this->controller . '.Search')){
					$search = $this->session->read('Layout.' . $this->controller . '.Search');
				}
			}

			$this->set('search', $search['s']);

			$search['s'] = '%'.str_replace(' ', '%', $search['s']).'%';
			//$this->paginate['conditions'] = ['Invoices.name LIKE' => $q ];
			$this->paginate['conditions'][] = [
				'OR' => [
					['Invoices.sub_id LIKE' => $search['s'] ],
					['Invoices.name LIKE' => $search['s'] ],
					['Invoices.invoiceNumber LIKE' => $search['s'] ],
					['Invoices.email LIKE' => $search['s'] ],
					['Invoices.status LIKE' => $search['s'] ],
					['Invoices.sent LIKE' => $search['s'] ],
				]
			];

		}
		// -- /.Filter --

		try {
			$invoices = $this->paginate($this->Invoices);
		} catch (NotFoundException $e) {
			$paging = $this->request->getAttribute('paging');
			if($paging['Invoices']['prevPage'] !== null && $paging['Invoices']['prevPage']){
				if($paging['Invoices']['page'] !== null && $paging['Invoices']['page'] > 0){
					return $this->redirect([
						'controller' => $this->controller,
						'action' => 'index',
						'?' => [
							'page'		=> 1,	//$this->paging['Invoices']['page'],
							'sort'		=> $this->paging['Invoices']['sort'],
							'direction'	=> $this->paging['Invoices']['direction'],
						],
					]);
				}
			}

		}

		$paging = $this->request->getAttribute('paging');

		if($this->paging !== $paging){
			$this->paging = $paging;
			$this->session->write('Layout.' . $this->controller . '.Paging', $paging);
		}

		//debug($invoices->toArray()); die();

		$this->set('paging', $this->paging);
		$this->set('layout' . $this->controller . 'LastId', $this->session->read('Layout.' . $this->controller . '.LastId'));
		$this->set(compact('invoices'));

	}


    /**
     * View method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->set('title', __('Invoice'));

        $invoice = $this->Invoices->get($id, [
            'contain' => ['MyUsers', 'Templates'],
        ]);

		$this->session->write('Layout.' . $this->controller . '.LastId', $id);

		$name = $invoice->name;

        $this->set(compact('invoice', 'id', 'name'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->Flash->error(__('Ez a funkció nem elérhető!'));
		return $this->redirect([
			'controller' => $this->controller,
			'action' => 'index',
			'?' => [
				'page'		=> 1,
				'sort'		=> 'id',
				'direction'	=> 'desc',
			],
		]);


		$this->set('title', __('Invoice'));
        $invoice = $this->Invoices->newEmptyEntity();
        if ($this->request->is('post')) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                //$this->Flash->success(__('The invoice has been saved.'));
                $this->Flash->success(__('Has been saved.'));

				$this->session->write('Layout.' . $this->controller . '.LastId', $invoice->id);

                //return $this->redirect(['action' => 'index']);
                return $this->redirect([
					'controller' => $this->controller,
					'action' => 'index',
					'?' => [
						'page'		=> 1,
						'sort'		=> 'id',
						'direction'	=> 'desc',
					],
					'#' => $invoice->id	// Az állandó header miatt takarásban van még. Majd...
				]);

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The invoice could not be saved. Please, try again.'));
			$this->Flash->error(__('Could not be saved. Please, try again.'));
        }
        //$myUsers = $this->Invoices->MyUsers->find('list', ['limit' => 200]);	// Original
		//$myUsers = $this->Invoices->MyUsers->find('list', ['limit' => 200, 'conditions'=>['MyUsers.visible' => 1], 'order'=>['MyUsers.pos' => 'asc', 'MyUsers.name' => 'asc']]);
		$myUsers = $this->Invoices->MyUsers->find('list', ['limit' => 200, 'order'=>['MyUsers.last_name' => 'asc', 'MyUsers.first_name' => 'asc']]);
        //$templates = $this->Invoices->Templates->find('list', ['limit' => 200]);	// Original
		//$templates = $this->Invoices->Templates->find('list', ['limit' => 200, 'conditions'=>['Templates.visible' => 1], 'order'=>['Templates.pos' => 'asc', 'Templates.name' => 'asc']]);
		$templates = $this->Invoices->Templates->find('list', ['limit' => 200, 'order'=>['Templates.id' => 'asc']]);
        //$subs = $this->Invoices->Subs->find('list', ['limit' => 200]);	// Original
		//$subs = $this->Invoices->Subs->find('list', ['limit' => 200, 'conditions'=>['Subs.visible' => 1], 'order'=>['Subs.pos' => 'asc', 'Subs.name' => 'asc']]);
		//$subs = $this->Invoices->Subs->find('list', ['limit' => 200, 'order'=>['Subs.pos' => 'asc', 'Subs.name' => 'asc']]);
        $this->set(compact('invoice', 'myUsers', 'templates'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->set('title', __('Invoice'));
        $invoice = $this->Invoices->get($id, [
            'contain' => [],
        ]);

		$this->session->write('Layout.' . $this->controller . '.LastId', $id);

        if ($this->request->is(['patch', 'post', 'put'])) {
			//debug($this->request->getData()); //die();
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            //debug($invoice); //die();
			if ($this->Invoices->save($invoice)) {
                //$this->Flash->success(__('The invoice has been saved.'));
                $this->Flash->success(__('Has been saved.'));

				//return $this->redirect(['action' => 'index']);
                return $this->redirect([
					'controller' => $this->controller,
					'action' => 'index',
					'?' => [
						'page'		=> (isset($this->paging['Invoices']['page'])) ? $this->paging['Invoices']['page'] : 1, 		// or 1
						'sort'		=> (isset($this->paging['Invoices']['sort'])) ? $this->paging['Invoices']['sort'] : 'created',
						'direction'	=> (isset($this->paging['Invoices']['direction'])) ? $this->paging['Invoices']['direction'] : 'desc',
					],
					'#' => $id
				]);

            }
            //$this->Flash->error(__('The invoice could not be saved. Please, try again.'));
            $this->Flash->error(__('Could not be saved. Please, try again.'));
        }
        //$myUsers = $this->Invoices->MyUsers->find('list', ['limit' => 200]);
		//$myUsers = $this->Invoices->MyUsers->find('list', ['limit' => 200, 'conditions'=>['MyUsers.visible' => 1], 'order'=>['MyUsers.pos' => 'asc', 'MyUsers.name' => 'asc']]);
		$myUsers = $this->Invoices->MyUsers->find('list', ['limit' => 200, 'order'=>['MyUsers.last_name' => 'asc', 'MyUsers.first_name' => 'asc']]);
        //$templates = $this->Invoices->Templates->find('list', ['limit' => 200]);
		//$templates = $this->Invoices->Templates->find('list', ['limit' => 200, 'conditions'=>['Templates.visible' => 1], 'order'=>['Templates.pos' => 'asc', 'Templates.name' => 'asc']]);
		$templates = $this->Invoices->Templates->find('list', ['limit' => 200, 'order'=>['Templates.id' => 'asc']]);
        //$subs = $this->Invoices->Subs->find('list', ['limit' => 200]);
		//$subs = $this->Invoices->Subs->find('list', ['limit' => 200, 'conditions'=>['Subs.visible' => 1], 'order'=>['Subs.pos' => 'asc', 'Subs.name' => 'asc']]);
		//$subs = $this->Invoices->Subs->find('list', ['limit' => 200, 'order'=>['Subs.pos' => 'asc', 'Subs.name' => 'asc']]);

		$name = $invoice->name;

        $this->set(compact('invoice', 'myUsers', 'templates', 'id', 'name'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoice = $this->Invoices->get($id);
        if ($this->Invoices->delete($invoice)) {
            //$this->Flash->success(__('The invoice has been deleted.'));
            $this->Flash->success(__('Has been deleted.'));
        } else {
            //$this->Flash->error(__('The invoice could not be deleted. Please, try again.'));
            $this->Flash->error(__('Could not be deleted. Please, try again.'));
        }

        //return $this->redirect(['action' => 'index']);
		return $this->redirect([
			'controller' => $this->controller,
			'action' => 'index',
			'?' => [
				'page'		=> $this->paging['Invoices']['page'],
				'sort'		=> $this->paging['Invoices']['sort'],
				'direction'	=> $this->paging['Invoices']['direction'],
			]
		]);

    }

}

