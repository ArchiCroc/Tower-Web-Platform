<?php

require_once dirname(__FILE__) . '/../../../../../application/models/Group/Acl/Service.php';

/**
 * Test class for Core_Model_Group_Acl_Acl_Service.
 * Generated by PHPUnit on 2011-06-22 at 08:07:56.
 */
class Core_Model_Group_Acl_ServiceTest extends PHPUnit_Framework_TestCase {

   /**
     * @var Core_Model_Group_Acl_Service
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Core_Model_Group_Acl_Service();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
       $this->object->deleteAll();
    }

    public function testGetMapper() {

        $this->assertInstanceOf('Core_Model_Group_Acl_MapperInterface', $this->object->getMapper());
    }

    /**
     * @todo Implement testSetMapper().
     */
    public function testSetMapper() {
        
        $mapper = new Core_Model_Group_Acl_MapperDbTable();
         $this->object->setMapper($mapper);
        
        $this->assertInstanceOf('Core_Model_Group_Acl_MapperInterface', $this->object->getMapper());
        $this->assertEquals($mapper, $this->object->getMapper());
        //$this->ass
    }
    

    public $id;
    public $group;
    public $module = null;
    public $controller;
    public $action;
    public $permission;
    
    

    private function createValidGroupAcl() {
        $groupAcl = new Core_Model_Group_Acl();
        $groupAcl->group = 1;
        $groupAcl->module = 'core';
        $groupAcl->controller = 'index';
        $groupAcl->action = 'new';
        $groupAcl->permission = 1;

        $result = $this->object->create($groupAcl);

        $this->assertInstanceOf('Core_Model_Group_Acl_Interface', $result);
        return $result;
    }
    
    public function testCreateInvalidGroupAcl() {
        $groupAcl = new Core_Model_Group_Acl();
        $groupAcl->group = 1;
        $groupAcl->module = null;
        $groupAcl->controller = 'index';
        //$groupAcl->action = 'new';
        $groupAcl->permission = 1;
        $this->setExpectedException('Exception');
        $result = $this->object->create($groupAcl);
    }
//    
//    public function testDuplicateUrl() {
//
//        $groupAcl1 = $this->createValidGroupAcl();
//        $this->setExpectedException('DuplicateEntryException');
//        $groupAcl2 = $this->createValidGroupAcl();
//    }

    public function testCreateValidFromObject() {

        $result = $this->createValidGroupAcl();       

        $this->assertNotNull($result->id);
        $this->assertEquals(1, $result->group);
        $this->assertEquals('core', $result->module);
        $this->assertEquals('index', $result->controller);
        $this->assertEquals('new', $result->action);
        $this->assertEquals(1, $result->permission);
    }
    
    public function testCreateFromArray() {

        $groupAcl = array(
            'group' => 1,
            'module' => 'homenet',
            'controller' => 'test',
            'action' => 'edit',
            'permission' => 0);

        $result = $this->object->create($groupAcl);

        $this->assertInstanceOf('Core_Model_Group_Acl_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertEquals(1, $result->group);
        $this->assertEquals('homenet', $result->module);
        $this->assertEquals('test', $result->controller);
        $this->assertEquals('edit', $result->action);
        $this->assertEquals(0, $result->permission);
    }

    public function testCreateException() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->object->create($badObject);
    }

    public function testGetObjectById() {

        //setup
        $groupAcl = $this->createValidGroupAcl();

        //test getObject
        $result = $this->object->getObjectById($groupAcl->id);
        
        $this->assertInstanceOf('Core_Model_Group_Acl_Interface', $result);
        
        $this->assertNotNull($result->id);
        $this->assertEquals(1, $result->group);
        $this->assertEquals('core', $result->module);
        $this->assertEquals('index', $result->controller);
        $this->assertEquals('new', $result->action);
        $this->assertEquals(1, $result->permission);
    }
    
//    public function testGetObjectByUrl() {
//
//        //setup
//        $groupAcl = $this->createValidGroupAcl();
//
//        //test getObject
//        $result = $this->object->getObjectByUrl($groupAcl->url);
//        
//        $this->assertInstanceOf('Core_Model_Group_Acl_Interface', $result);
//
//        $this->assertEquals($groupAcl->id, $result->id);
//        $this->assertEquals(0, $result->set);
//        $this->assertEquals(1, $result->parent);
//        $this->assertEquals(2, $result->order);
//        $this->assertEquals('testUrl', $result->url);
//        $this->assertEquals('testTitle', $result->title);
//        $this->assertEquals('testDescription', $result->description);
//    }
//    
//     public function testGetInvalidObjectByUrl() {
//
//        $this->setExpectedException('NotFoundException');
//        $result = $this->object->getObjectByUrl("testnotindatabase");
//
//    }

    public function testUpdateFromObject() {

        //setup
        $groupAcl = $this->createValidGroupAcl();

        //update values
        $groupAcl->group = 2;
        $groupAcl->module = 'blog';
        $groupAcl->controller = 'admin';
        $groupAcl->action = 'view';
        $groupAcl->permission = 0;

        $result = $this->object->update($groupAcl);

        $this->assertInstanceOf('Core_Model_Group_Acl_Interface', $result);

        $this->assertEquals($groupAcl->id,$result->id);
        $this->assertEquals(2, $result->group);
        $this->assertEquals('blog', $result->module);
        $this->assertEquals('admin', $result->controller);
        $this->assertEquals('view', $result->action);
        $this->assertEquals(0, $result->permission);
    }
    
    public function testUpdateFromArray() {

        //setup
        $groupAcl = $this->createValidGroupAcl();

        $array = $groupAcl->toArray();
        
        //update values
        $array['group'] = 2;
        $array['module'] = 'blog';
        $array['controller'] = 'admin';
        $array['action'] = 'view';
        $array['permission'] = 0;


        $result = $this->object->update($array);

        $this->assertInstanceOf('Core_Model_Group_Acl_Interface', $result);

        $this->assertEquals($groupAcl->id,$result->id);
        $this->assertEquals(2, $result->group);
        $this->assertEquals('blog', $result->module);
        $this->assertEquals('admin', $result->controller);
        $this->assertEquals('view', $result->action);
        $this->assertEquals(0, $result->permission);
    }
    

    public function testUpdateException() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->object->update($badObject);
    }

    public function testDeleteObject() {

        //setup
        $groupAcl = $this->createValidGroupAcl();

        //test delete
        $this->object->delete($groupAcl);

        //verify that it was deleted
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectById($groupAcl->id);
    }

    public function testDeleteId() {

        //setup
        $groupAcl = $this->createValidGroupAcl();
       // $this->fail("id: ".$groupAcl->id);
        $this->object->delete((int)$groupAcl->id);
        
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectById($groupAcl->id); 
    }
    
    public function testDeleteArray() {

        //setup
        $groupAcl = $this->createValidGroupAcl();
       // $this->fail("id: ".$groupAcl->id);
        $this->object->delete($groupAcl->toArray());
        
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectById($groupAcl->id); 
    }

    public function testDeleteException() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->object->delete($badObject);
    }

    public function testDeleteAll() {
//        $this->object->deleteAll();
    }

}

?>
