<?php


namespace OCA\NotesTutorial\Dashboard;


use OCA\NotesTutorial\AppInfo\Application;
use OCP\Dashboard\IWidget;
use OCP\IURLGenerator;

class NotesWidget implements IWidget {

	/**
	 * @var IURLGenerator
	 */
	private $urlGenerator;

	public function __construct(IURLGenerator $urlGenerator) {
		$this->urlGenerator = $urlGenerator;
	}

	public function getId(): string {
		return Application::APP_ID;
	}

	public function getTitle(): string {
		return 'Notes';
	}

	public function getOrder(): int {
		return 90;
	}

	public function getIconClass(): string {
		return 'icon-rename';
	}

	public function getUrl(): ?string {
		return $this->urlGenerator->getAbsoluteURL('/apps/notestutorial');
	}

	public function load(): void {
		\OCP\Util::addScript('notestutorial', 'notestutorial-dashboard');
	}
}
