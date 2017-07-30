<?php
namespace OCA\NotesTutorial\Controller;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\App;
use Test\TestCase;

use OCA\NotesTutorial\Db\Note;

class NoteIntregrationTest extends TestCase {

    private $controller;
    private $mapper;
    private $userId = 'john';

    public function setUp() {
        parent::setUp();
        $app = new App('notestutorial');
        $container = $app->getContainer();

        // only replace the user id
        $container->registerService('UserId', function($c) {
            return $this->userId;
        });

        $this->controller = $container->query(
            'OCA\NotesTutorial\Controller\NoteController'
        );

        $this->mapper = $container->query(
            'OCA\NotesTutorial\Db\NoteMapper'
        );
    }

    public function testUpdate() {
        // create a new note that should be updated
        $note = new Note();
        $note->setTitle('old_title');
        $note->setContent('old_content');
        $note->setUserId($this->userId);

        $id = $this->mapper->insert($note)->getId();

        // fromRow does not set the fields as updated
        $updatedNote = Note::fromRow([
            'id' => $id,
            'user_id' => $this->userId
        ]);
        $updatedNote->setContent('content');
        $updatedNote->setTitle('title');

        $result = $this->controller->update($id, 'title', 'content');

        $this->assertEquals($updatedNote, $result->getData());

        // clean up
        $this->mapper->delete($result->getData());
    }

}
