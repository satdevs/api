<?php
// Baked at 2022.05.09. 13:17:18
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

/**
 * Circularletters Controller
 *
 * @property \App\Model\Table\CircularlettersTable $Circularletters
 * @method \App\Model\Entity\Circularletter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CircularlettersController extends AppController
{

    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
		$this->set('title', __('Circularletters'));

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
		$circularletters = null;

		$this->set('title', __('Circularletters'));

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
            'contain' => ['Templates'],
			'conditions' => [
				//'Circularletters.name' 		=> 1,
				//'Circularletters.visible' 		=> 1,
				//'Circularletters.created >= ' 	=> new \DateTime('-10 days'),
				//'Circularletters.modified >= '	=> new \DateTime('-10 days'),
			],
			/*
			// Nem tanácsos az order-t itt használni, mert pl az edit után az utolsó  ordert ugyan beálíltja, de
			// kiegészíti ezzel s így az utoljára mentett rekord nem lesz megtalálható az X-edik oldalon, mert az az elsőre kerül.
			// A felhasználó állítson be rendezettséget magának! Kivételes esetek persze lehetnek!
			*/
			'order' => [
				//'Circularletters.id' 			=> 'desc',
				//'Circularletters.name' 		=> 'asc',
				//'Circularletters.visible' 		=> 'desc',
				//'Circularletters.pos' 			=> 'desc',
				//'Circularletters.rank' 		=> 'asc',
				//'Circularletters.created' 		=> 'desc',
				//'Circularletters.modified' 	=> 'desc',
			],
			'limit' => $this->config['index_number_of_rows'],
			'maxLimit' => $this->config['index_number_of_rows'],
			//'sortableFields' => ['id', 'name', 'created', '...'],
			//'paramType' => 'querystring',
			//'fields' => ['Circularletters.id', 'Circularletters.name', ...],
			//'finder' => 'published',
        ];

		//$this->paging = $this->session->read('Layout.' . $this->controller . '.Paging');

		if( $this->paging === null){
			$this->paginate['order'] = [
				//'Circularletters.id' 			=> 'desc',
				//'Circularletters.name' 		=> 'asc',
				//'Circularletters.visible' 		=> 'desc',
				//'Circularletters.pos' 			=> 'desc',
				//'Circularletters.rank' 		=> 'asc',
				//'Circularletters.created' 		=> 'desc',
				//'Circularletters.modified' 	=> 'desc',
			];
		}else{
			if($this->request->getQuery('sort') === null && $this->request->getQuery('direction') === null){
				$this->paginate['order'] = [
					// If not in URL-ben, then come from sessinon...
					$this->paging['Circularletters']['sort'] => $this->paging['Circularletters']['direction']
				];
			}
		}

		if($this->request->getQuery('page') === null && !isset($this->paging['Circularletters']['page']) ){
			$this->paginate['page'] = 1;
		}else{
			$this->paginate['page'] = (isset($this->paging['Circularletters']['page'])) ? $this->paging['Circularletters']['page'] : 1;
		}

		// -- Filter --
		if ($this->request->is('post') || $this->session->read('Layout.' . $this->controller . '.Search') !== null && $this->session->read('Layout.' . $this->controller . '.Search') !== []) {

			$this->paginate['conditions'] = [];	// Ha keresés van, akkor nel egyen a régi szűrés bekapcsolva. Ez a rész kikommentelhető!

			if( $this->request->is('post') ){
				$search = $this->request->getData();
				$this->session->write('Layout.' . $this->controller . '.Search', $search);
				if($search !== null && $search['s'] !== null && $search['s'] == ''){
					$this->session->delete('Layout.' . $this->controller . '.Search');
					return $this->redirect([
						'controller' => $this->controller,
						'action' => 'index',
						//'?' => [			// Not tested!!!
						//	'page'		=> $this->paging['Circularletters']['page'], 	// Vagy 1
						//	'sort'		=> $this->paging['Circularletters']['sort'],
						//	'direction'	=> $this->paging['Circularletters']['direction'],
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
			//$this->paginate['conditions'] = ['Circularletters.name LIKE' => $q ];
			$this->paginate['conditions'][] = [
				'OR' => [
					['Circularletters.name LIKE' => $search['s'] ],
					//['Circularletters.title LIKE' => $search['s'] ], // ... just add more fields
				]
			];

		}
		// -- /.Filter --

		try {
			$circularletters = $this->paginate($this->Circularletters);
		} catch (NotFoundException $e) {
			$paging = $this->request->getAttribute('paging');
			if($paging['Circularletters']['prevPage'] !== null && $paging['Circularletters']['prevPage']){
				if($paging['Circularletters']['page'] !== null && $paging['Circularletters']['page'] > 0){
					return $this->redirect([
						'controller' => $this->controller,
						'action' => 'index',
						'?' => [
							'page'		=> 1,	//$this->paging['Circularletters']['page'],
							'sort'		=> $this->paging['Circularletters']['sort'],
							'direction'	=> $this->paging['Circularletters']['direction'],
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

		$this->set('paging', $this->paging);
		$this->set('layout' . $this->controller . 'LastId', $this->session->read('Layout.' . $this->controller . '.LastId'));
		$this->set(compact('circularletters'));

	}
    /**
     * View method
     *
     * @param string|null $id Circularletter id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->set('title', __('Circularletter'));

        $circularletter = $this->Circularletters->get($id, [
            'contain' => ['Templates'],
        ]);

		$this->session->write('Layout.' . $this->controller . '.LastId', $id);

		$name = $circularletter->name;

        $this->set(compact('circularletter', 'id', 'name'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->set('title', __('Circularletter'));
        $circularletter = $this->Circularletters->newEmptyEntity();
        if ($this->request->is('post')) {
            $circularletter = $this->Circularletters->patchEntity($circularletter, $this->request->getData());
            if ($this->Circularletters->save($circularletter)) {
                //$this->Flash->success(__('The circularletter has been saved.'));
                $this->Flash->success(__('Has been saved.'));

				$this->session->write('Layout.' . $this->controller . '.LastId', $circularletter->id);

                //return $this->redirect(['action' => 'index']);
                return $this->redirect([
					'controller' => $this->controller,
					'action' => 'index',
					'?' => [
						'page'		=> 1,
						'sort'		=> 'id',
						'direction'	=> 'desc',
					],
					'#' => $circularletter->id	// Az állandó header miatt takarásban van még. Majd...
				]);

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The circularletter could not be saved. Please, try again.'));
			$this->Flash->error(__('Could not be saved. Please, try again.'));
        }
        //$templates = $this->Circularletters->Templates->find('list', ['limit' => 200]);	// Original
		//$templates = $this->Circularletters->Templates->find('list', ['limit' => 200, 'conditions'=>['Templates.visible' => 1], 'order'=>['Templates.pos' => 'asc', 'Templates.name' => 'asc']]);
		$templates = $this->Circularletters->Templates->find('list', ['limit' => 200, 'order'=>['Templates.pos' => 'asc', 'Templates.name' => 'asc']]);
        $this->set(compact('circularletter', 'templates'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Circularletter id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->set('title', __('Circularletter'));
        $circularletter = $this->Circularletters->get($id, [
            'contain' => [],
        ]);

		$this->session->write('Layout.' . $this->controller . '.LastId', $id);

        if ($this->request->is(['patch', 'post', 'put'])) {
			//debug($this->request->getData()); //die();
            $circularletter = $this->Circularletters->patchEntity($circularletter, $this->request->getData());
            //debug($circularletter); //die();
			if ($this->Circularletters->save($circularletter)) {
                //$this->Flash->success(__('The circularletter has been saved.'));
                $this->Flash->success(__('Has been saved.'));

				//return $this->redirect(['action' => 'index']);
                return $this->redirect([
					'controller' => $this->controller,
					'action' => 'index',
					'?' => [
						'page'		=> (isset($this->paging['Circularletters']['page'])) ? $this->paging['Circularletters']['page'] : 1, 		// or 1
						'sort'		=> (isset($this->paging['Circularletters']['sort'])) ? $this->paging['Circularletters']['sort'] : 'created',
						'direction'	=> (isset($this->paging['Circularletters']['direction'])) ? $this->paging['Circularletters']['direction'] : 'desc',
					],
					'#' => $id
				]);

            }
            //$this->Flash->error(__('The circularletter could not be saved. Please, try again.'));
            $this->Flash->error(__('Could not be saved. Please, try again.'));
        }
        //$templates = $this->Circularletters->Templates->find('list', ['limit' => 200]);
		//$templates = $this->Circularletters->Templates->find('list', ['limit' => 200, 'conditions'=>['Templates.visible' => 1], 'order'=>['Templates.pos' => 'asc', 'Templates.name' => 'asc']]);
		$templates = $this->Circularletters->Templates->find('list', ['limit' => 200, 'order'=>['Templates.pos' => 'asc', 'Templates.name' => 'asc']]);

		$name = $circularletter->name;

        $this->set(compact('circularletter', 'templates', 'id', 'name'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Circularletter id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $circularletter = $this->Circularletters->get($id);
        if ($this->Circularletters->delete($circularletter)) {
            //$this->Flash->success(__('The circularletter has been deleted.'));
            $this->Flash->success(__('Has been deleted.'));
        } else {
            //$this->Flash->error(__('The circularletter could not be deleted. Please, try again.'));
            $this->Flash->error(__('Could not be deleted. Please, try again.'));
        }

        //return $this->redirect(['action' => 'index']);
		return $this->redirect([
			'controller' => $this->controller,
			'action' => 'index',
			'?' => [
				'page'		=> $this->paging['Circularletters']['page'],
				'sort'		=> $this->paging['Circularletters']['sort'],
				'direction'	=> $this->paging['Circularletters']['direction'],
			]
		]);

    }

}

