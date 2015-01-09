<?php
/**
 * ownCloud - ownnotes
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author ray <ray>
 * @copyright ray 2015
 */

namespace OCA\OwnNotes\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\App;

class PageControllerTest extends PHPUnit_Framework_TestCase {

	private $request;
	private $controller;
	private $userId = 'john';

	public function setUp() {
		$app = new App('ownnotes');
		$container = $app->getContainer();

		$this->request = $this->getMockBuilder('OCP\IRequest')->getMock();
		$container->registerService('OCP\IRequest', function($c) {
			return $this->request;
		});

		$container->registerService('UserId', function($c) {
			return $this->userId;
		});

		$this->controller = $container->query(
			'OCA\OwnNotes\Controller\PageController'
		);
	}


	public function testIndex() {
		$result = $this->controller->index();

		$this->assertEquals('main', $result->getTemplateName());
		$this->assertTrue($result instanceof TemplateResponse);
	}

}