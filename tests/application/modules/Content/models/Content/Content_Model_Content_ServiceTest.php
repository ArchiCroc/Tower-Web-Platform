<?php

//require_once dirname(__FILE__) . '/../../../../../../application/modules/Content/models/Section/Content/Service.php';

/**
 * Test class for Content_Model_Content_Service.
 * Generated by PHPUnit on 2011-06-22 at 08:15:15.
 */
class Content_Model_Content_ServiceTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Content_Model_Content_Service
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Content_Model_Content_Service;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
//      $this->object->deleteAll();
    }

    public function testGetMapper() {

        $this->assertInstanceOf('Content_Model_Content_MapperInterface', $this->object->getMapper());
    }

    /**
     * @todo Implement testSetMapper().
     */
    public function testSetMapper() {
        
        $mapper = new Content_Model_Content_MapperDbTable();
         $this->object->setMapper($mapper);
        
        $this->assertInstanceOf('Content_Model_Content_MapperInterface', $this->object->getMapper());
        $this->assertEquals($mapper, $this->object->getMapper());
        //$this->ass
    }

    private function createValidContent() {
        $content = new Content_Model_Content();
        
        //$content->id = 1;
       // $content->revision = 2;
        $content->section = 3;
        $content->active = true;
        $content->status = 4;
        $content->date = date('Y-m-d H:i:s', strtotime('+1 week'));
        $content->expires = date('Y-m-d H:i:s', strtotime('+2 week'));
        $content->author = 5;
        $content->editor = 6;
        $content->title = 'testTitle';
        $content->url = 'testUrl';
        $content->visible = true;
        $content->content = array('body' => 'value');
      
        $result = $this->object->create($content);

        $this->assertInstanceOf('Content_Model_Content_Interface', $result);
        return $result;
    }
    
    public function testCreateInvalidContent() {
        
        $content = new Content_Model_Content();
       // $content->revision = 2;
        $content->section = 3;
        $content->active = true;
        $content->status = 4;
        $content->date = null ;
        $content->expires = date('Y-m-d H:i:s', strtotime('+1 week'));
      //  $content->author = 5;
        $content->editor = 6;
        $content->url = 'testUrl';
        $content->title = 'testTitle';
        $content->visible = true;
        $content->content = array('body' => 'value');
        $this->setExpectedException('Exception');
        $result = $this->object->create($content);
    }
//    
//    public function testDuplicateUrl() {
//
//        $content1 = $this->createValidContent();
//        $this->setExpectedException('DuplicateEntryException');
//        $content2 = $this->createValidContent();
//    }

    public function testCreateValidFromObject() {

        $result = $this->createValidContent();

        $this->assertNotNull($result->id);
        $this->assertNotNull($result->revision);
        $this->assertEquals(3, $result->section);
        $this->assertEquals(true, $result->active);
        $this->assertEquals(4, $result->status);
        $this->assertNotNull($result->date);
        $this->assertNotNull($result->expires);
        $this->assertEquals(5, $result->author);
        $this->assertEquals(6, $result->editor);
        $this->assertEquals('testUrl', $result->url);
        $this->assertEquals('testTitle', $result->title);
        $this->assertArrayHasKey('body', $result->content);
        $this->assertEquals(true, $result->visible);
        $this->assertEquals('value', $result->content['body']);
    }
    
//     public function testToArray() {
//
//        $content = new Content_Model_Content();
//        
//        $content->status = 0;
//        $content->primary_group = 1;
//        $content->username = 'testContentname';
//        $content->name = 'testName';
//        $content->location = 'testLocation';
//        $content->email = 'test@test.com';
//        $content->permissions = null;
//        $content->settings = array('test' => 'value');
//
//        $array = $content->toArray();
//        
//        $this->assertArrayHasKey('primary_group', $array);
//        $this->assertEquals(1, $array['primary_group']);
//    }
    
    public function testCreateFromArray() {

        $content = array(
//            'id' => 1,
//            'revision' => 2,
            'section' => 3,
            'active' => true,
            'status' => 4,
            'created' => null,
            'expires' => null,
            'author' => 5,
            'editor' => 6,
            'url' => 'testUrl',
            'title' => 'testTitle',
            'visible' => true,
            'content' => array('body' => 'value'));
        
        

        $result = $this->object->create($content);

        $this->assertInstanceOf('Content_Model_Content_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertNotNull($result->revision);
        $this->assertEquals(3, $result->section);
        $this->assertEquals(true, $result->active);
        $this->assertEquals(4, $result->status);
        $this->assertNull($result->date);
        $this->assertNull($result->expires);
        $this->assertEquals(5, $result->author);
        $this->assertEquals(6, $result->editor);
        $this->assertEquals('testUrl', $result->url);
        $this->assertEquals('testTitle', $result->title);
        $this->assertEquals(true, $result->active);
        $this->assertArrayHasKey('body', $result->content);
        $this->assertEquals('value', $result->content['body']);
    }

    public function testCreateException() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->object->create($badObject);
    }

    public function testGetObjectById() {

        //setup
        $content = $this->createValidContent();

        //test getObject
        $result = $this->object->getObjectByIdRevision($content->id,$content->revision);
        
        $this->assertInstanceOf('Content_Model_Content_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertNotNull($result->revision);
        $this->assertEquals(3, $result->section);
        $this->assertEquals(true, $result->active);
        $this->assertEquals(4, $result->status);
        $this->assertNotNull($result->date);
        $this->assertNotNull($result->expires);
        $this->assertEquals(5, $result->author);
        $this->assertEquals(6, $result->editor);
        $this->assertEquals('testUrl', $result->url);
        $this->assertEquals('testTitle', $result->title);
        $this->assertEquals(true, $result->active);
        $this->assertArrayHasKey('body', $result->content);
        $this->assertEquals('value', $result->content['body']);
    }
    
//    public function testGetObjectByUrl() {
//
//        //setup
//        $content = $this->createValidContent();
//
//        //test getObject
//        $result = $this->object->getObjectByUrl($content->url);
//        
//        $this->assertInstanceOf('Content_Model_Content_Interface', $result);
//
//        $this->assertEquals($content->id, $result->id);
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
        $content = $this->createValidContent();

        //update values
        $content->section = 4;
        $content->active = false;
        $content->status = 5;
        $content->date = new Zend_Date(strtotime('+1 week')) ;
        $content->expires = new Zend_Date(strtotime('+2 week'));
        $content->author = 6;
        $content->editor = 7;
        $content->url = 'testUrl2';
        $content->title = 'testTitle2';
        $content->visible = false;
        $content->content = array('body' => 'value2');

        $result = $this->object->update($content);

        $this->assertInstanceOf('Content_Model_Content_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertNotNull($result->revision);
        $this->assertEquals(4, $result->section);
        $this->assertEquals(false, $result->active);
        $this->assertEquals(5, $result->status);
        $this->assertNotNull($result->date);
        $this->assertNotNull($result->expires);
        $this->assertEquals(6, $result->author);
        $this->assertEquals(7, $result->editor);
        $this->assertEquals('testUrl2', $result->url);
        $this->assertEquals('testTitle2', $result->title);
        $this->assertEquals(false, $result->active);
        $this->assertArrayHasKey('body', $result->content);
        $this->assertEquals('value2', $result->content['body']);
    }
    
    public function testUpdateFromArray() {

        //setup
        $content = $this->createValidContent();

        $array = $content->toArray();
        
        //update values          
        $array['section'] = 4;
        $array['active'] = false;
        $array['status'] = 5;
        $array['created'] = new Zend_Date(strtotime('+1 week')) ;
        $array['expires'] = new Zend_Date(strtotime('+2 week'));
        $array['author'] = 6;
        $array['editor'] = 7;
        $array['url'] = 'testUrl2';
        $array['title'] = 'testTitle2';
        $array['visible'] = false;
        $array['content'] = array('body' => 'value2');


        $result = $this->object->update($array);

        $this->assertInstanceOf('Content_Model_Content_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertNotNull($result->revision);
        $this->assertEquals(4, $result->section);
        $this->assertEquals(false, $result->active);
        $this->assertEquals(5, $result->status);
        $this->assertNotNull($result->date);
        $this->assertNotNull($result->expires);
        $this->assertEquals(6, $result->author);
        $this->assertEquals(7, $result->editor);
        $this->assertEquals('testUrl2', $result->url);
        $this->assertEquals('testTitle2', $result->title);
        $this->assertEquals(false, $result->visible);
        $this->assertArrayHasKey('body', $result->content);
        $this->assertEquals('value2', $result->content['body']);
    }
    

    public function testUpdateException() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->object->update($badObject);
    }

    public function testDeleteObject() {

        //setup
        $content = $this->createValidContent();

        //test delete
        $this->object->delete($content);

        //verify that it was deleted
        $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectByIdRevision($content->id,$content->revision);
    }

//    public function testDeleteId() {
//
//        //setup
//        $content = $this->createValidContent();
//       // $this->fail("id: ".$content->id);
//        $this->object->delete((int)$content->id);
//        
//        $this->setExpectedException('NotFoundException');
//        $result = $this->object->getObjectByIdRevision($content->id,$content->revision); 
//    }
    
    public function testDeleteArray() {

        //setup
        $content = $this->createValidContent();
       // $this->fail("id: ".$content->id);
        $this->object->delete($content->toArray());
        
       // $this->setExpectedException('NotFoundException');
        $result = $this->object->getObjectByIdRevision($content->id,$content->revision); 
        $this->fail(debugArray($result));
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
