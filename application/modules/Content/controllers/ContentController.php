<?php

class Content_ContentController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->controllerTitle = 'Content'; //for generic templates
        $this->view->id = $this->_getParam('id');
    }

    public function indexAction()
    {
        $service = new Content_Model_Content_Service();
        $this->view->assign('objects', $service->getObjectsBySection($this->_getParam('id')));
    }

    public function newAction()
    {
        $this->_helper->viewRenderer->setNoController(true); //use generic templates
        $manager = new Content_Model_Section_Manager();
        $form = $manager->getForm($this->_getParam('id'));
        $form->addElement('submit', 'submit', array('label' => 'Create'));
        $this->view->assign('form',$form);
        
        if (!$this->getRequest()->isPost()) {
            //first
            $this->view->form = $form;
            return;
        }

        if (!$form->isValid($_POST)) {
            // Failed validation; redisplay form
            $this->view->form = $form;
            return;
        }
        
        //save
        $values = $form->getValues();

        $service = new Content_Model_Content_Service();
        $values['section'] = $this->view->id;
        $service->create($values);
        
        return $this->_redirect($this->view->url(array('controller'=>'content', 'action'=>'index', 'id'=>$this->view->id),'content-id').'?message=Successfully added');//
    }

    public function editAction()
    {
        $this->_helper->viewRenderer->setNoController(true); //use generic templates
        
        $service = new Content_Model_Content_Service();
        $manager = new Content_Model_Section_Manager();
        $form = $manager->getForm($this->_getParam('id'));
        $form->addElement('submit', 'submit', array('label' => 'Update'));
        $form->addElement('hidden', 'section');
        if (!$this->getRequest()->isPost()) {
            //load exsiting values
            $object = $service->getObjectById($this->_getParam('id'));
            
            $values = $object->toArray();

            $form->populate($values);

            $this->view->form = $form;
            return;
        }

        if (!$form->isValid($_POST)) {
            // Failed validation; redisplay form
            $this->view->form = $form;
            return;
        }

        //save
        $values = $form->getValues();
         $object = $service->getObjectById($this->_getParam('id'));
         $object->fromArray($values);
        $service->update($object);

        return $this->_redirect($this->view->url(array('controller'=>'content', 'action'=>'index', 'id'=>$values['section']),'content-id').'?message=Updated');//
    }

    public function deleteAction()
    {
        $this->_helper->viewRenderer->setNoController(true); //use generic templates
        
        $service = new Content_Model_Content_Service();
        $object = $service->getObjectById($this->_getParam('id'));
        $form = new Core_Form_Confirm();

        if (!$this->getRequest()->isPost() || !$form->isValid($_POST)) {

            $form->addDisplayGroup($form->getElements(), 'node', array ('legend' => 'Are you sure you want to delete "'.$object->title.'"?'));

            $this->view->form = $form;
            return;
        }
        $section = $object->section;

        $values = $form->getValues();

        //need to figure out why this isn't in values
        if(!empty($_POST['delete'])){
            
            $service->delete($object);
            return $this->_redirect($this->view->url(array('controller'=>'content', 'action'=>'index', 'id'=>$section),'content-id').'?message=Deleted');
        }
        return $this->_redirect($this->view->url(array('controller'=>'content', 'action'=>'index', 'id'=>$section),'content-id').'?message=Canceled');
    }

    public function hideAction()
    {
        // action body
    }

    public function showAction()
    {
        // action body
    }
}