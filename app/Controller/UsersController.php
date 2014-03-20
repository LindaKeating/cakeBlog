<?php
class UsersController extends AppController {
	
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	
    public function isAuthorized($user){
    	if(in_array($this->action, array('add'))){
    		return true;
    	}
    	if(in_array($this->action, array('view', 'edit', 'delete'))){
    		
    		$userId = $this->request->params['pass'][0];
    		if($this->Auth->user('id')=== $userId){
    			debug($this->Auth->user('role'));
    			return true;
    		}
    		else
    		{
    		$this->Session->setFlash(__('Sorry only Admin users may modify , view or delete other users'));	
    		}
    	}
    	return parent::isAuthorized($user);
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout','login');
    }
    

    
	public function login() {		
    	if ($this->request->is('post')) {
        	if ($this->Auth->login()) {
            	return $this->redirect($this->Auth->redirectUrl());
        	}
        $this->Session->setFlash(__('Invalid username or password, try again'));
    	}
	}
	
	public function logout(){
		return $this->redirect($this->Auth->logout());
	}

    public function index() {
    	debug(AuthComponent::user());
        $this->User->recursive = 1;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

}