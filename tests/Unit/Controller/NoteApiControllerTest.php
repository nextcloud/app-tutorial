<?php

namespace OCA\NotesTutorial\Tests\Unit\Controller;

use OCA\NotesTutorial\Controller\NoteApiController;

class NoteApiControllerTest extends NoteControllerTest {
	public function setUp(): void {
		parent::setUp();
		$this->controller = new NoteApiController($this->request, $this->service, $this->userId);
	}
}
