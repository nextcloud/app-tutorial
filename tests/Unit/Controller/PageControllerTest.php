<?php

namespace OCA\NotesTutorial\Controller;

use OCP\AppFramework\Http\TemplateResponse;

use PHPUnit\Framework\TestCase;

class PageControllerTest extends TestCase {
	private $controller;

	public function setUp(): void {
		$request = $this->getMockBuilder('OCP\IRequest')->getMock();
		$this->controller = new PageController($request);
	}


	public function testIndex() {
		$result = $this->controller->index();

		$this->assertEquals('main', $result->getTemplateName());
		$this->assertTrue($result instanceof TemplateResponse);
	}
}
