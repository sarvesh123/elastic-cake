<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
 */
class PostsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {

		$this->Post->recursive = 0;
		$this->set('posts', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {

		if ($esPost = $this->Post->queryDoc($id)) {
			$this->set('post', $esPost);
		}
		else {
			if (!$this->Post->exists($id)) {
				throw new NotFoundException(__('Invalid post'));
			}
			$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
			$this->set('post', $this->Post->find('first', $options));
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Flash->set(__('The post has been saved.'));

				$this->Post->createIndex($this->Post->id);

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The post could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Post->save($this->request->data)) {
				$this->Flash->set(__('The post has been saved.'));

				$this->Post->createIndex($this->Post->id);

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The post could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
			$this->request->data = $this->Post->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Post->delete()) {
			$this->Flash->set(__('The post has been deleted.'));
		} else {
			$this->Flash->set(__('The post could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function search( $keyword = false ) {
        $this->set('posts', $this->Post->listAll($keyword));
	}
}
