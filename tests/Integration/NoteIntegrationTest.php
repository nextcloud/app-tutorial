<?php

namespace OCA\NotesTutorial\Tests\Integration\Controller;

use OCP\AppFramework\App;
use OCP\IRequest;
use PHPUnit\Framework\TestCase;


use OCA\NotesTutorial\Db\Note;
use OCA\NotesTutorial\Db\NoteMapper;
use OCA\NotesTutorial\Controller\NoteController;

class NoteIntegrationTest extends TestCase {
	private $controller;
	private $mapper;
	private $userId = 'john';

	public function setUp(): void {
		$app = new App('notestutorial');
		$container = $app->getContainer();

		// only replace the user id
		$container->registerService('userId', function () {
			return $this->userId;
		});

		// we do not care about the request but the controller needs it
		$container->registerService(IRequest::class, function () {
			return $this->createMock(IRequest::class);
		});

		$this->controller = $container->query(NoteController::class);
		$this->mapper = $container->query(NoteMapper::class);
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
