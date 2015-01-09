<?php
namespace OCA\OwnNotes\Controller;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\App;
use OCP\AppFramework\Db\DoesNotExistException;

use OCA\OwnNotes\Db\Note;

class NoteControllerTest extends \PHPUnit_Framework_TestCase {

    private $request;
    private $controller;
    private $mapper;
    private $userId = 'john';

    public function setUp() {
        // app is the class that builds all the classes automatically for use
        // it needs the app id as the first parameter
        $app = new App('ownnotes');
        $container = $app->getContainer();

        // now we overwrite certain classes with mocks so we can return
        // testable values
        $this->request = $this->getMockBuilder('OCP\IRequest')->getMock();
        $container->registerService('OCP\IRequest', function($c) {
            return $this->request;
        });

        $container->registerService('UserId', function($c) {
            return $this->userId;
        });

        // when mocking normal classes, we need to deactivate the constructor
        $this->mapper = $this->getMockBuilder('OCA\OwnNotes\Db\NoteMapper')
            ->disableOriginalConstructor()
            ->getMock();
        $container->registerService('OCA\OwnNotes\Db\NoteMapper', function($c) {
            return $this->mapper;
        });

        // after all the mocks are in place we ask the container to build a new
        // NoteController instance
        $this->controller = $container->query(
            'OCA\OwnNotes\Controller\NoteController'
        );
    }

    public function testUpdate() {
        // the existing note
        $note = Note::fromRow([
            'id' => 3,
            'title' => 'yo',
            'content' => 'nope'
        ]);
        $this->mapper->expects($this->once())
            ->method('find')
            ->with($this->equalTo(3))
            ->will($this->returnValue($note));

        // the note when updated
        $updatedNote = Note::fromRow(['id' => 3]);
        $updatedNote->setTitle('title');
        $updatedNote->setContent('content');
        $this->mapper->expects($this->once())
            ->method('update')
            ->with($this->equalTo($updatedNote))
            ->will($this->returnValue($updatedNote));

        $result = $this->controller->update(3, 'title', 'content');

        $this->assertEquals($updatedNote, $result->getData());
    }


    public function testUpdateNotFound() {
        // test the correct status code if no note is found
        $this->mapper->expects($this->once())
            ->method('find')
            ->with($this->equalTo(3))
            ->will($this->throwException(new DoesNotExistException('')));

        $result = $this->controller->update(3, 'title', 'content');

        $this->assertEquals(Http::STATUS_NOT_FOUND, $result->getStatus());
    }

}