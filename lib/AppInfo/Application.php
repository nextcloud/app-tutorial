<?php

namespace OCA\NotesTutorial\AppInfo;

use OCA\NotesTutorial\Dashboard\NotesWidget;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap {
	public const APP_ID = 'notestutorial';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void {
		$context->registerDashboardWidget(NotesWidget::class);
	}

	public function boot(IBootContext $context): void {
		// This app does not require any boot code
	}
}
