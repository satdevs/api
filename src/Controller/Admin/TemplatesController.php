<?php
// Baked at 2022.05.06. 10:05:58
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

/**
 * Templates Controller
 *
 * @property \App\Model\Table\TemplatesTable $Templates
 * @method \App\Model\Entity\Template[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TemplatesController extends AppController
{

    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
		$this->set('title', __('Templates'));
		
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
		$templates = null;
		
		$this->set('title', __('Templates'));

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
				//'Templates.name' 		=> 1,
				//'Templates.visible' 		=> 1,
				//'Templates.created >= ' 	=> new \DateTime('-10 days'),
				//'Templates.modified >= '	=> new \DateTime('-10 days'),
			],
			/*
			// Nem tanácsos az order-t itt használni, mert pl az edit után az utolsó  ordert ugyan beálíltja, de
			// kiegészíti ezzel s így az utoljára mentett rekord nem lesz megtalálható az X-edik oldalon, mert az az elsőre kerül.
			// A felhasználó állítson be rendezettséget magának! Kivételes esetek persze lehetnek!
			*/
			'order' => [
				//'Templates.id' 			=> 'desc',
				//'Templates.name' 		=> 'asc',
				//'Templates.visible' 		=> 'desc',
				//'Templates.pos' 			=> 'desc',
				//'Templates.rank' 		=> 'asc',
				//'Templates.created' 		=> 'desc',
				//'Templates.modified' 	=> 'desc',
			],
			'limit' => $this->config['index_number_of_rows'],
			'maxLimit' => $this->config['index_number_of_rows'],
			//'sortableFields' => ['id', 'name', 'created', '...'],
			//'paramType' => 'querystring',
			//'fields' => ['Templates.id', 'Templates.name', ...],
			//'finder' => 'published',
        ];

		//$this->paging = $this->session->read('Layout.' . $this->controller . '.Paging');

		if( $this->paging === null){
			$this->paginate['order'] = [
				//'Templates.id' 			=> 'desc',
				//'Templates.name' 		=> 'asc',
				//'Templates.visible' 		=> 'desc',
				//'Templates.pos' 			=> 'desc',
				//'Templates.rank' 		=> 'asc',
				//'Templates.created' 		=> 'desc',
				//'Templates.modified' 	=> 'desc',
			];
		}else{
			if($this->request->getQuery('sort') === null && $this->request->getQuery('direction') === null){
				$this->paginate['order'] = [
					// If not in URL-ben, then come from sessinon...
					$this->paging['Templates']['sort'] => $this->paging['Templates']['direction']	
				];
			}
		}

		if($this->request->getQuery('page') === null && !isset($this->paging['Templates']['page']) ){
			$this->paginate['page'] = 1;
		}else{
			$this->paginate['page'] = (isset($this->paging['Templates']['page'])) ? $this->paging['Templates']['page'] : 1;
		}
		
		// -- Filter --
		if ($this->request->is('post') || $this->session->read('Layout.' . $this->controller . '.Search') !== null && $this->session->read('Layout.' . $this->controller . '.Search') !== []) {
				
			if( $this->request->is('post') ){
				$search = $this->request->getData();
				$this->session->write('Layout.' . $this->controller . '.Search', $search);
				if($search !== null && $search['s'] !== null && $search['s'] == ''){
					$this->session->delete('Layout.' . $this->controller . '.Search');
					return $this->redirect([
						'controller' => $this->controller, 
						'action' => 'index', 
						//'?' => [			// Not tested!!!
						//	'page'		=> $this->paging['Templates']['page'], 	// Vagy 1
						//	'sort'		=> $this->paging['Templates']['sort'], 
						//	'direction'	=> $this->paging['Templates']['direction'],
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
			//$this->paginate['conditions'] = ['Templates.name LIKE' => $q ];
			$this->paginate['conditions'][] = [
				'OR' => [
					['Templates.name LIKE' => $search['s'] ],
					//['Templates.title LIKE' => $search['s'] ], // ... just add more fields
				]
			];
			
		}
		// -- /.Filter --
		
		try {
			$templates = $this->paginate($this->Templates);
		} catch (NotFoundException $e) {
			$paging = $this->request->getAttribute('paging');
			if($paging['Templates']['prevPage'] !== null && $paging['Templates']['prevPage']){
				if($paging['Templates']['page'] !== null && $paging['Templates']['page'] > 0){
					return $this->redirect([
						'controller' => $this->controller, 
						'action' => 'index', 
						'?' => [
							'page'		=> 1,	//$this->paging['Templates']['page'],
							'sort'		=> $this->paging['Templates']['sort'],
							'direction'	=> $this->paging['Templates']['direction'],
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
		$this->set(compact('templates'));
		
	}


    /**
     * View method
     *
     * @param string|null $id Template id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->set('title', __('Template'));
		
        $template = $this->Templates->get($id, [
            'contain' => ['Circularletters', 'Invoices', 'InvoicesOld'],
        ]);

		$this->session->write('Layout.' . $this->controller . '.LastId', $id);

		$name = $template->name;

        $this->set(compact('template', 'id', 'name'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->set('title', __('Template'));
        $template = $this->Templates->newEmptyEntity();
        if ($this->request->is('post')) {
            $template = $this->Templates->patchEntity($template, $this->request->getData());
            if ($this->Templates->save($template)) {
                //$this->Flash->success(__('The template has been saved.'));
                $this->Flash->success(__('Has been saved.'));

				$this->session->write('Layout.' . $this->controller . '.LastId', $template->id);
	
                //return $this->redirect(['action' => 'index']);
                return $this->redirect([
					'controller' => $this->controller, 
					'action' => 'index', 
					'?' => [
						'page'		=> 1,
						'sort'		=> 'id',
						'direction'	=> 'desc',
					],
					'#' => $template->id	// Az állandó header miatt takarásban van még. Majd...
				]);

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The template could not be saved. Please, try again.'));
			$this->Flash->error(__('Could not be saved. Please, try again.'));
        }
        $this->set(compact('template'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Template id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->set('title', __('Template'));
        $template = $this->Templates->get($id, [
            'contain' => [],
        ]);

		$this->session->write('Layout.' . $this->controller . '.LastId', $id);

        if ($this->request->is(['patch', 'post', 'put'])) {
			//debug($this->request->getData()); //die();
            $template = $this->Templates->patchEntity($template, $this->request->getData());
            //debug($template); //die();
			if ($this->Templates->save($template)) {
                //$this->Flash->success(__('The template has been saved.'));
                $this->Flash->success(__('Has been saved.'));
				
				//return $this->redirect(['action' => 'index']);
                return $this->redirect([
					'controller' => $this->controller, 
					'action' => 'index', 
					'?' => [
						'page'		=> (isset($this->paging['Templates']['page'])) ? $this->paging['Templates']['page'] : 1, 		// or 1
						'sort'		=> (isset($this->paging['Templates']['sort'])) ? $this->paging['Templates']['sort'] : 'created', 
						'direction'	=> (isset($this->paging['Templates']['direction'])) ? $this->paging['Templates']['direction'] : 'desc',
					],
					'#' => $id
				]);
				
            }
            //$this->Flash->error(__('The template could not be saved. Please, try again.'));
            $this->Flash->error(__('Could not be saved. Please, try again.'));
        }

		$name = $template->name;

        $this->set(compact('template', 'id', 'name'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Template id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $template = $this->Templates->get($id);
        if ($this->Templates->delete($template)) {
            //$this->Flash->success(__('The template has been deleted.'));
            $this->Flash->success(__('Has been deleted.'));
        } else {
            //$this->Flash->error(__('The template could not be deleted. Please, try again.'));
            $this->Flash->error(__('Could not be deleted. Please, try again.'));
        }

        //return $this->redirect(['action' => 'index']);
		return $this->redirect([
			'controller' => $this->controller, 
			'action' => 'index', 
			'?' => [
				'page'		=> $this->paging['Templates']['page'], 
				'sort'		=> $this->paging['Templates']['sort'], 
				'direction'	=> $this->paging['Templates']['direction'],
			]
		]);
		
    }

}

