<?php
// Baked at 2022.05.09. 10:01:40
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

/**
 * Simplepays Controller
 *
 * @property \App\Model\Table\SimplepaysTable $Simplepays
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
		$this->set('title', __('Simplepays'));

	}

    /**
     * Index method
     *
	 * @param string|null $param: if($param !== null && $param == 'clear-filter')...
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($param = null)
    {

		//echo ROOT . DS . 'logs' . DS;
		//die();

/*
		$egyenleg = -10000;
		$havidij = -10000;

		if($egyenleg >= $havidij+1){
			echo "Kimarad";
		}

		die("xxx");
*/
		/*
						// 4756

		IF aEgyenleg[4] >= ((nHaviDij * -1) - 1)	// +1 a kerekítések miatt. Akár beleeshet egy-egy ügyfél a listába.
			LOOP
		ENDIF
		*/


		$search = null;
		$simplepays = null;

		$this->set('title', __('Simplepays'));

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
			'conditions' => [
				//'Simplepays.name' 		=> 1,
				//'Simplepays.visible' 		=> 1,
				//'Simplepays.created >= ' 	=> new \DateTime('-10 days'),
				//'Simplepays.modified >= '	=> new \DateTime('-10 days'),
				'Simplepays.ipnStatus' => "FINISHED",
//				'Simplepays.winszlaStatus' => "PAID"	// NEW, ...
			],

			/*
			// Nem tanácsos az order-t itt használni, mert pl az edit után az utolsó  ordert ugyan beálíltja, de
			// kiegészíti ezzel s így az utoljára mentett rekord nem lesz megtalálható az X-edik oldalon, mert az az elsőre kerül.
			// A felhasználó állítson be rendezettséget magának! Kivételes esetek persze lehetnek!
			*/
			'order' => [
				//'Simplepays.id' 			=> 'desc',
				//'Simplepays.name' 		=> 'asc',
				//'Simplepays.visible' 		=> 'desc',
				//'Simplepays.pos' 			=> 'desc',
				//'Simplepays.rank' 		=> 'asc',
				//'Simplepays.created' 		=> 'desc',
				//'Simplepays.modified' 	=> 'desc',
			],
			'limit' => $this->config['index_number_of_rows'],
			'maxLimit' => $this->config['index_number_of_rows'],
			//'sortableFields' => ['id', 'name', 'created', '...'],
			//'paramType' => 'querystring',
			//'fields' => ['Simplepays.id', 'Simplepays.name', ...],
			//'finder' => 'published',
        ];

		//$this->paging = $this->session->read('Layout.' . $this->controller . '.Paging');

		if( $this->paging === null){
			$this->paginate['order'] = [
				//'Simplepays.id' 			=> 'desc',
				//'Simplepays.name' 		=> 'asc',
				//'Simplepays.visible' 		=> 'desc',
				//'Simplepays.pos' 			=> 'desc',
				//'Simplepays.rank' 		=> 'asc',
				'Simplepays.created' 		=> 'desc',
				//'Simplepays.modified' 	=> 'desc',
			];
		}else{
			if($this->request->getQuery('sort') === null && $this->request->getQuery('direction') === null){
				$this->paginate['order'] = [
					// If not in URL-ben, then come from sessinon...
					$this->paging['Simplepays']['sort'] => $this->paging['Simplepays']['direction']
				];
			}
		}

		if($this->request->getQuery('page') === null && !isset($this->paging['Simplepays']['page']) ){
			$this->paginate['page'] = 1;
		}else{
			$this->paginate['page'] = (isset($this->paging['Simplepays']['page'])) ? $this->paging['Simplepays']['page'] : 1;
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
						//	'page'		=> $this->paging['Simplepays']['page'], 	// Vagy 1
						//	'sort'		=> $this->paging['Simplepays']['sort'],
						//	'direction'	=> $this->paging['Simplepays']['direction'],
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
			//$this->paginate['conditions'] = ['Simplepays.name LIKE' => $q ];
			$this->paginate['conditions'][] = [
				'OR' => [
					['Simplepays.name LIKE' => $search['s'] ],
					//['Simplepays.title LIKE' => $search['s'] ], // ... just add more fields
				]
			];

		}
		// -- /.Filter --

		try {
			$simplepays = $this->paginate($this->Simplepays);
		} catch (NotFoundException $e) {
			$paging = $this->request->getAttribute('paging');
			if($paging['Simplepays']['prevPage'] !== null && $paging['Simplepays']['prevPage']){
				if($paging['Simplepays']['page'] !== null && $paging['Simplepays']['page'] > 0){
					return $this->redirect([
						'controller' => $this->controller,
						'action' => 'index',
						'?' => [
							'page'		=> 1,	//$this->paging['Simplepays']['page'],
							'sort'		=> $this->paging['Simplepays']['sort'],
							'direction'	=> $this->paging['Simplepays']['direction'],
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

		//foreach($simplepays as $simplepay){
		//	debug($simplepay);
		//}
		//
		////debug($simplepays);
		//die();

		$this->set('paging', $this->paging);
		$this->set('layout' . $this->controller . 'LastId', $this->session->read('Layout.' . $this->controller . '.LastId'));
		$this->set(compact('simplepays'));

	}


    /**
     * View method
     *
     * @param string|null $id Simplepay id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->set('title', __('Simplepay'));

        $simplepay = $this->Simplepays->get($id, [
            'contain' => [],
        ]);

		$this->session->write('Layout.' . $this->controller . '.LastId', $id);

		$name = $simplepay->name;

        $this->set(compact('simplepay', 'id', 'name'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->set('title', __('Simplepay'));
        $simplepay = $this->Simplepays->newEmptyEntity();
        if ($this->request->is('post')) {
            $simplepay = $this->Simplepays->patchEntity($simplepay, $this->request->getData());
            if ($this->Simplepays->save($simplepay)) {
                //$this->Flash->success(__('The simplepay has been saved.'));
                $this->Flash->success(__('Has been saved.'));

				$this->session->write('Layout.' . $this->controller . '.LastId', $simplepay->id);

                //return $this->redirect(['action' => 'index']);
                return $this->redirect([
					'controller' => $this->controller,
					'action' => 'index',
					'?' => [
						'page'		=> 1,
						'sort'		=> 'id',
						'direction'	=> 'desc',
					],
					'#' => $simplepay->id	// Az állandó header miatt takarásban van még. Majd...
				]);

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The simplepay could not be saved. Please, try again.'));
			$this->Flash->error(__('Could not be saved. Please, try again.'));
        }
        $this->set(compact('simplepay'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Simplepay id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->set('title', __('Simplepay'));
        $simplepay = $this->Simplepays->get($id, [
            'contain' => [],
        ]);

		$this->session->write('Layout.' . $this->controller . '.LastId', $id);

        if ($this->request->is(['patch', 'post', 'put'])) {
			//debug($this->request->getData()); //die();
            $simplepay = $this->Simplepays->patchEntity($simplepay, $this->request->getData());
            //debug($simplepay); //die();
			if ($this->Simplepays->save($simplepay)) {
                //$this->Flash->success(__('The simplepay has been saved.'));
                $this->Flash->success(__('Has been saved.'));

				//return $this->redirect(['action' => 'index']);
                return $this->redirect([
					'controller' => $this->controller,
					'action' => 'index',
					'?' => [
						'page'		=> (isset($this->paging['Simplepays']['page'])) ? $this->paging['Simplepays']['page'] : 1, 		// or 1
						'sort'		=> (isset($this->paging['Simplepays']['sort'])) ? $this->paging['Simplepays']['sort'] : 'created',
						'direction'	=> (isset($this->paging['Simplepays']['direction'])) ? $this->paging['Simplepays']['direction'] : 'desc',
					],
					'#' => $id
				]);

            }
            //$this->Flash->error(__('The simplepay could not be saved. Please, try again.'));
            $this->Flash->error(__('Could not be saved. Please, try again.'));
        }

		$name = $simplepay->name;

        $this->set(compact('simplepay', 'id', 'name'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Simplepay id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $simplepay = $this->Simplepays->get($id);
        if ($this->Simplepays->delete($simplepay)) {
            //$this->Flash->success(__('The simplepay has been deleted.'));
            $this->Flash->success(__('Has been deleted.'));
        } else {
            //$this->Flash->error(__('The simplepay could not be deleted. Please, try again.'));
            $this->Flash->error(__('Could not be deleted. Please, try again.'));
        }

        //return $this->redirect(['action' => 'index']);
		return $this->redirect([
			'controller' => $this->controller,
			'action' => 'index',
			'?' => [
				'page'		=> $this->paging['Simplepays']['page'],
				'sort'		=> $this->paging['Simplepays']['sort'],
				'direction'	=> $this->paging['Simplepays']['direction'],
			]
		]);

    }

}

