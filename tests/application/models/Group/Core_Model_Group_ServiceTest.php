<?php

require_once dirname(__FILE__) . '/../../../../application/models/Group/Service.php';

/**
 * Test class for Core_Model_Group_Service.
 * Generated by PHPUnit on 2011-06-22 at 18:34:04.
 */
class Core_Model_Group_ServiceTest extends PHPUnit_Framework_TestCase {

   /**
     * @var Core_Model_Group_Service
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Core_Model_Group_Service;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
       $this->object->deleteAll();
    }

    public function testGetMapper() {

        $this->assertInstanceOf('Core_Model_Group_MapperInterface', $this->object->getMapper());
    }

    /**
     * @todo Implement testSetMapper().
     */
    public function testSetMapper() {
        
        $mapper = new Core_Model_Group_MapperDbTable();
         $this->object->setMapper($mapper);
        
        $this->assertInstanceOf('Core_Model_Group_MapperInterface', $this->object->getMapper());
        $this->assertEquals($mapper, $this->object->getMapper());
        //$this->ass
    }

    private function createValidGroup() {
        $group = new Core_Model_Group();

        $group->parent = 0;
        $group->type = 1;
  
        $group->title = 'testTitle';
        $group->description = 'testDescription';
        $group->visible = true;
        $group->user_count = 2;
        $group->settings = array('system' => 'test');

        $result = $this->object->create($group);

        $this->assertInstanceOf('Core_Model_Group_Interface', $result);
        return $result;
    }
    
    public function testCreateInvalidGroup() {
        $group = new Core_Model_Group();
        $group->parent = 0;
        $group->type = 1;
       // $group->title = 'testTitle';
       // $group->description = 'testDescription';
        $group->user_count = 2;
        $group->settings = array('system' => 'test');
        $this->setExpectedException('Exception');
        $result = $this->object->create($group);
    }
//    
//    public function testDuplicateUrl() {
//
//        $group1 = $this->createValidGroup();
//        $this->setExpectedException('DuplicateEntryException');
//        $group2 = $this->createValidGroup();
//    }

    public function testCreateValidFromObject() {

        $result = $this->createValidGroup();

        $this->assertNotNull($result->id);
        $this->assertEquals(0, $result->parent);
        $this->assertEquals(1, $result->type);
        $this->assertEquals('testTitle', $result->title);
        $this->assertEquals('testDescription', $result->description);
        $this->assertEquals(true, $result->visible);
        $this->assertEquals(2, $result->user_count);
        $this->assertArrayHasKey('system', $result->settings);
    }
    
    public function testCreateFromArray() {

        $group = array(
            'parent' => 0,
            'type' => 1,
            'title' => 'testTitle',
            'description' => 'testDescription',
            'visible' => false,
            'user_count' => 2,
            'settings' => array('system' => 'test'));

        $result = $this->object->create($group);

        $this->assertInstanceOf('Core_Model_Group_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertEquals(0, $result->parent);
        $this->assertEquals(1, $result->type);
        $this->assertEquals('testTitle', $result->title);
        $this->assertEquals('testDescription', $result->description);
        $this->assertEquals(false, $result->visible);
        $this->assertEquals(2, $result->user_count);
        $this->assertArrayHasKey('system', $result->settings);
    }

    public function testCreateException() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->object->create($badObject);
    }

    public function testGetObjectById() {

        //setup
        $group = $this->createValidGroup();

        //test getObject
        $result = $this->object->getObjectById($group->id);
        
        $this->assertInstanceOf('Core_Model_Group_Interface', $result);

         $this->assertNotNull($result->id);
        $this->assertEquals(0, $result->parent);
        $this->assertEquals(1, $result->type);
        $this->assertEquals('testTitle', $result->title);
        $this->assertEquals('testDescription', $result->description);
        $this->assertEquals(true, $result->visible);
        $this->assertEquals(2, $result->user_count);
        $this->assertArrayHasKey('system', $result->settings);
    }
    
//    public function testGetObjectByUrl() {
//
//        //setup
//        $group = $this->createValidGroup();
//
//        //test getObject
//        $result = $this->object->getObjectByUrl($group->url);
//        
//        $this->assertInstanceOf('Core_Model_Group_Interface', $result);
//
//        $this->assertEquals($group->id, $result->id);
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
        $group = $this->createValidGroup();

        //update values
        $group->parent = 1;
        $group->type = 2;
        $group->title = 'testTitle2';
        $group->description = 'testDescription2';
        $group->visible = false;
        $group->user_count = 3;
        $group->settings = array('system' => 'test');

        $result = $this->object->update($group);

        $this->assertInstanceOf('Core_Model_Group_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertEquals(1, $result->parent);
        $this->assertEquals(2, $result->type);
        $this->assertEquals('testTitle2', $result->title);
        $this->assertEquals('testDescription2', $result->description);
        $this->assertEquals(false, $result->visible);
        $this->assertEquals(3, $result->user_count);
        $this->assertArrayHasKey('system', $result->settings);
    }
    
    public function testUpdateFromArray() {

        //setup
        $group = $this->createValidGroup();

        $array = $group->toArray();
        
        //update values
        $array['parent'] = 1;
        $array['type'] = 2;
        $array['title'] = 'testTitle2';
        $array['description'] = 'testDescription2';
        $array['visible'] = false;
        $array['user_count'] = 3;
        $array['settings'] = array('system' => 'test');

        $result = $this->object->update($array);

        $this->assertInstanceOf('Core_Model_Group_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertEquals(1, $result->parent);
        $this->assertEquals(2, $result->type);
        $this->assertEquals('testTitle2', $result->title);
        $this->assertEquals('testDescription2', $result->description);
        $this->assertEquals(false, $result->visible);
        $this->assertEquals(3, $result->user_count);
        $this->assertArrayHasKey('system', $result->settings);
    }
    

    public function testUpdateException() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->object->update($badObject);
    }

    public function testDeleteObject() {

        //setup
        $group = $this->createValidGroup();

        //test delete
        $this->object->delete($group);

        //verify that it was deleted
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectById($group->id);
    }

    public function testDeleteId() {

        //setup
        $group = $this->createValidGroup();
       // $this->fail("id: ".$group->id);
        $this->object->delete((int)$group->id);
        
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectById($group->id); 
    }
    
    public function testDeleteArray() {

        //setup
        $group = $this->createValidGroup();
       // $this->fail("id: ".$group->id);
        $this->object->delete($group->toArray());
        
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectById($group->id); 
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
