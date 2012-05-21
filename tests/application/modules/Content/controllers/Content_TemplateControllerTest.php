<?php

/**
 * Test class for Content_TemplateController.
 * Generated by PHPUnit on 2011-11-17 at 04:07:41.
 */

require_once APPLICATION_PATH . '/modules/Content/Installer.php';

class Content_TemplateControllerTest extends Zend_Test_PHPUnit_ControllerTestCase {

    private $service;
    private $installer;
    private $contentInstaller;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {

        $this->installer = new Core_Installer();
        $this->installer->installTest();
        $this->installer->loginAsSuperAdmin();
        
        
        $this->bootstrap = new Zend_Application('testing', APPLICATION_PATH . '/configs/application.ini'); //
        $this->view = Zend_Registry::get('view');
        
        $manager = new Core_Model_User_Manager();
        $manager->login(array('username'=>'testSuperAdmin','password'=>'password'));
     
        $this->contentInstaller = new Content_Installer();
        $this->contentInstaller->installTest();

        $this->service = new Content_Model_Template_Service();
        parent::setUp();
        
        $request = $this->getRequest();
        $request->setModuleName('Content');
        $request->setControllerName('Template');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @see Content_Model_Template_ServiceTest
     */
    private function createValidObject() {
        $object = new Content_Model_Template();

        //$content->id = 1;
        // $content->revision = 2;
        $object->owner = $this->installer->user->superAdmin->id;
        $object->section = $this->contentInstaller->section->test->id;
        $object->autosave = false;
        $object->url = 'testurl345353';
        $object->type = 1;
        $object->visible = true;
        $object->active = true;
        $object->content = 'testContent';

        $result = $this->service->create($object);

        $this->assertInstanceOf('Content_Model_Template_Interface', $result);
        return $result;
    }

    public function testIndexAction() {
        //setup
        $this->createValidObject();
        
        $this->getRequest()->setActionName('Index');
        $this->getRequest()->setParam('id',  $this->contentInstaller->section->test->id);
        
        //run
        $this->dispatch();

        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('Index');
        $this->assertContains('testurl345353', $this->response->outputBody());
    }

    public function testNewAction_firstView() {
        //setup
        $this->getRequest()->setActionName('New');
        $this->getRequest()->setParam('id', $this->contentInstaller->section->test->id);
        
        //run
        $this->dispatch();
        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('New');
        $this->assertNotRedirect();

    }
    
    public function testNewAction_submitInvalid() {
        //setup
        $this->getRequest()->setActionName('New');
        $this->getRequest()->setParam('id', $this->contentInstaller->section->test->id);

        $this->getRequest()->setMethod('POST')
                ->setPost(array(
                    'url' => '',
                    'visible' => true,
                    'active' => true,
                    'content' => ''));

        //run
        $this->dispatch();
        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('New');
        $this->assertNotRedirect();
    }
    
    public function testNewAction_submitValid() {
        //setup
        $this->getRequest()->setActionName('New');
        $this->getRequest()->setParam('id', $this->contentInstaller->section->test->id);
        $this->getRequest()->setMethod('POST')
                ->setPost(array(
                    'url' => 'testUrl',
                    'visible' => true,
                    'active' => true,
                    'content' => 'testContent'));

        //run
        $this->dispatch();
        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('New');
        $this->assertRedirect();
    }

    public function testEditAction_firstView() {
        //setup
        $object = $this->createValidObject();
        $this->getRequest()->setActionName('Edit');
        $this->getRequest()->setParam('id', $object->id);

        //run
        $this->dispatch();
        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('Edit');
        $this->assertContains('testurl345353', $this->response->outputBody()); //make sure data is in the form
        $this->assertNotRedirect();
    }
    
    public function testEditAction_submitInvalid() {
        //setup
        $object = $this->createValidObject();
        $this->getRequest()->setActionName('Edit');
        $this->getRequest()->setParam('id', $object->id);
        $this->getRequest()->setMethod('POST')
                ->setPost(array(
                    'url' => '',
                    'visible' => false,
                    'active' => false,
                    'content' => ''));
        //run
        $this->dispatch();
        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('Edit');
        $this->assertNotRedirect();
    }
    
    public function testEditAction_submitValid() {
        //setup
        $object = $this->createValidObject();
        $this->getRequest()->setActionName('Edit');
        $this->getRequest()->setParam('id', $object->id);
        $this->getRequest()->setMethod('POST')
                ->setPost(array(
                    'url' => 'testurl2',
                    'visible' => false,
                    'active' => false,
                    'content' => 'testContentsdfsfsfs'));
        
        //run
        $this->dispatch();
        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('Edit');
        $this->assertRedirect();
    }

    public function testDeleteAction_firstView() {
        //setup
        $object = $this->createValidObject();
        $this->getRequest()->setActionName('Delete');
        $this->getRequest()->setParam('id', $object->id);

        //show form
        $this->dispatch();
        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('Delete');
        $this->assertContains('testurl345353', $this->response->outputBody()); //make sure data is in the form
        $this->assertNotRedirect();
    }
    public function testDeleteAction_submitCancel() {
        //setup
        $object = $this->createValidObject();
        $this->getRequest()->setActionName('Delete');
        $this->getRequest()->setParam('id', $object->id);
        $this->getRequest()->setMethod('POST')
                ->setPost(array('cancel' => 'cancel'));

        //run
        $this->dispatch();
        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('Delete');
        $this->assertRedirect();
    }
    public function testDeleteAction_submitDelete() {
        //setup
        $object = $this->createValidObject();
        $this->getRequest()->setActionName('Delete');
        $this->getRequest()->setParam('id', $object->id);
        $this->getRequest()->setMethod('POST')
                ->setPost(array('confirm' => 'confirm'));

        //run
        $this->dispatch();
        $this->assertModule('Content');
        $this->assertController('Template');
        $this->assertAction('Delete');
        $this->assertRedirect();
    }
}