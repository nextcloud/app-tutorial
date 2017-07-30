<?php
namespace OCA\NotesTutorial\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Http\TemplateResponse;

class PageControllerTest extends PHPUnit_Framework_TestCase {

	private $controller;

	public function setUp() {
		$request = $this->getMockBuilder('OCP\IRequest')->getMock();
		$this->controller = new PageController('notestutorial', $request);
	}


	public function testIndex() {
		$result = $this->controller->index();

		$this->assertEquals('main', $result->getTemplateName());
		$this->assertTrue($result instanceof TemplateResponse);
	}

}