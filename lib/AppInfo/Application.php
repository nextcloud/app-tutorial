<?php

namespace OCA\NotesTutorial\AppInfo;

use OCP\AppFramework\App;

class Application extends App {
	public const APP_ID = 'notestutorial';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}
}
