<?php
namespace OCA\NotesTutorial\Controller;

require_once __DIR__ . '/NoteControllerTest.php';

class NoteApiControllerTest extends NoteControllerTest {

    public function setUp() {
        parent::setUp();
        $this->controller = new NoteApiController(
            'notestutorial', $this->request, $this->service, $this->userId
        );
    }

}