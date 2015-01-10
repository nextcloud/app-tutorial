<?php
namespace OCA\OwnNotes\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Db\DoesNotExistException;

use OCA\OwnNotes\Db\Note;

class NoteControllerTest extends PHPUnit_Framework_TestCase {

    private $controller;
    private $mapper;
    private $userId = 'john';

    public function setUp() {
        $request = $this->getMockBuilder('OCP\IRequest')->getMock();
        $this->mapper = $this->getMockBuilder('OCA\OwnNotes\Db\NoteMapper')
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller = new NoteController(
            'ownnotes', $request, $this->mapper, $this->userId
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