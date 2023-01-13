<?php

namespace OCA\NotesTutorial\Controller;

use OCA\NotesTutorial\Service\NoteService;
use PHPUnit\Framework\TestCase;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Services\IInitialState;
use OCP\IRequest;
use OCP\IUserSession;

class PageControllerTest extends TestCase {
	private PageController $controller;
	private IUserSession|\PHPUnit\Framework\MockObject\MockObject $session;

	public function setUp(): void {
		/** @var IRequest|\PHPUnit\Framework\MockObject\MockObject */
		$request = $this->getMockBuilder(IRequest::class)->getMock();
		/** @var IInitialState|\PHPUnit\Framework\MockObject\MockObject */
		$initialState = $this->getMockBuilder(IInitialState::class)->getMock();
		/** @var NoteService|\PHPUnit\Framework\MockObject\MockObject */
		$service = $this->getMockBuilder(NoteService::class)->getMock();
		/** @var IUserSession|\PHPUnit\Framework\MockObject\MockObject */
		$this->session = $this->getMockBuilder(IUserSession::class)->getMock();

		$this->controller = new PageController($request, $initialState, $service, $this->session);
	}


	public function testIndex() {
		$result = $this->controller->index();

		$this->assertEquals('main', $result->getTemplateName());
		$this->assertTrue($result instanceof TemplateResponse);
	}

	public function testShowNote() {
		$result = $this->controller->showNote(1);

		$this->assertEquals('main', $result->getTemplateName());
		$this->assertTrue($result instanceof TemplateResponse);

		$this->session->expects($this->once())->method('getUser');
	}
}
