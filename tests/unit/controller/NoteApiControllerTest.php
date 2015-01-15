<?php
namespace OCA\OwnNotes\Controller;

require_once __DIR__ . '/NoteControllerTest.php';

class NoteApiControllerTest extends NoteControllerTest {

    public function setUp() {
        parent::setUp();
        $this->controller = new NoteApiController(
            'ownnotes', $this->request, $this->service, $this->userId
        );
    }

}