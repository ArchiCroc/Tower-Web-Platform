<?php

require_once dirname(__FILE__) . '/../../../../../application/models/Group/Acl/Service.php';

/**
 * Test class for Core_Model_User_Membership_Acl_Service.
 * Generated by PHPUnit on 2011-06-22 at 08:07:56.
 */
class Core_Model_User_Membership_ServiceTest extends PHPUnit_Framework_TestCase {

   /**
     * @var Core_Model_User_Membership_Service
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Core_Model_User_Membership_Service();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
       $this->object->deleteAll();
    }

    public function testGetMapper() {

        $this->assertInstanceOf('Core_Model_User_Membership_MapperInterface', $this->object->getMapper());
    }

    /**
     * @todo Implement testSetMapper().
     */
    public function testSetMapper() {
        
        $mapper = new Core_Model_User_Membership_MapperDbTable();
         $this->object->setMapper($mapper);
        
        $this->assertInstanceOf('Core_Model_User_Membership_MapperInterface', $this->object->getMapper());
        $this->assertEquals($mapper, $this->object->getMapper());
        //$this->ass
    }
    
 

    
    

    private function createValidUserMembership() {
        $userMembership = new Core_Model_User_Membership();
        $userMembership->user = 1;
        $userMembership->group = 2;


        $result = $this->object->create($userMembership);

        $this->assertInstanceOf('Core_Model_User_Membership_Interface', $result);
        return $result;
    }
    
    public function testCreateInvalidUserMembership() {
        $userMembership = new Core_Model_User_Membership();
        $userMembership->user = 1;
        
        $this->setExpectedException('Exception');
        $result = $this->object->create($userMembership);
    }
//    
//    public function testDuplicateUrl() {
//
//        $userMembership1 = $this->createValidUserMembership();
//        $this->setExpectedException('DuplicateEntryException');
//        $userMembership2 = $this->createValidUserMembership();
//    }

    public function testCreateValidFromObject() {

        $result = $this->createValidUserMembership();       

        $this->assertNotNull($result->id);
        $this->assertEquals(1, $result->user);
        $this->assertEquals(2, $result->group);
        $this->assertNotNull($result->created);
    }
    
    public function testCreateFromArray() {

        $userMembership = array(
            'user' => 1,
            'group' => 2);

        $result = $this->object->create($userMembership);

        $this->assertInstanceOf('Core_Model_User_Membership_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertEquals(1, $result->user);
        $this->assertEquals(2, $result->group);
        $this->assertNotNull($result->created);
    }

    public function testCreateException() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->object->create($badObject);
    }

    public function testGetObjectById() {

        //setup
        $userMembership = $this->createValidUserMembership();

        //test getObject
        $result = $this->object->getObjectById($userMembership->id);
        
        $this->assertInstanceOf('Core_Model_User_Membership_Interface', $result);
        
        $this->assertNotNull($result->id);
        $this->assertEquals(1, $result->user);
        $this->assertEquals(2, $result->group);
        $this->assertNotNull($result->created);
    }
    
//    public function testGetObjectByUrl() {
//
//        //setup
//        $userMembership = $this->createValidUserMembership();
//
//        //test getObject
//        $result = $this->object->getObjectByUrl($userMembership->url);
//        
//        $this->assertInstanceOf('Core_Model_User_Membership_Interface', $result);
//
//        $this->assertEquals($userMembership->id, $result->id);
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
        $userMembership = $this->createValidUserMembership();

        //update values
        $userMembership->user = 1;
        $userMembership->group = 3;

        $result = $this->object->update($userMembership);

        $this->assertInstanceOf('Core_Model_User_Membership_Interface', $result);

        $this->assertEquals($userMembership->id,$result->id);
        $this->assertEquals(1, $result->user);
        $this->assertEquals(3, $result->group);
        $this->assertNotNull($result->created);
    }
    
    public function testUpdateFromArray() {

        //setup
        $userMembership = $this->createValidUserMembership();

        $array = $userMembership->toArray();
        
        //update values
        $array['user'] = 1;
        $array['group'] = 3;

        $result = $this->object->update($array);

        $this->assertInstanceOf('Core_Model_User_Membership_Interface', $result);

        $this->assertEquals($userMembership->id,$result->id);
        $this->assertEquals(1, $result->user);
        $this->assertEquals(3, $result->group);
        $this->assertNotNull($result->created);
    }
    

    public function testUpdateException() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->object->update($badObject);
    }

    public function testDeleteObject() {

        //setup
        $userMembership = $this->createValidUserMembership();

        //test delete
        $this->object->delete($userMembership);

        //verify that it was deleted
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectById($userMembership->id);
    }

    public function testDeleteId() {

        //setup
        $userMembership = $this->createValidUserMembership();
       // $this->fail("id: ".$userMembership->id);
        $this->object->delete((int)$userMembership->id);
        
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectById($userMembership->id); 
    }
    
    public function testDeleteArray() {

        //setup
        $userMembership = $this->createValidUserMembership();
       // $this->fail("id: ".$userMembership->id);
        $this->object->delete($userMembership->toArray());
        
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectById($userMembership->id); 
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