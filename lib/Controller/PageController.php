<?php

namespace OCA\NotesTutorial\Controller;

use OCA\NotesTutorial\AppInfo\Application;
use OCA\NotesTutorial\Service\NoteNotFound;
use OCA\NotesTutorial\Service\NoteService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Services\IInitialState;
use OCP\IRequest;
use OCP\IUserSession;
use OCP\Util;

class PageController extends Controller {
	protected IInitialState $initialState;
	protected NoteService $service;
	protected IUserSession $session;

	public function __construct(IRequest $request, IInitialState $initialState, NoteService $service, IUserSession $session) {
		parent::__construct(Application::APP_ID, $request);
		$this->initialState = $initialState;
		$this->service = $service;
		$this->session = $session;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * Render default template
	 */
	public function index() {
		Util::addScript(Application::APP_ID, 'notestutorial-main');

		return new TemplateResponse(Application::APP_ID, 'main');
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * Show a specific note
	 */
	public function showNote(int $note) {
		Util::addScript(Application::APP_ID, 'notestutorial-main');

		$user = $this->session->getUser();
		if ($user !== null) {
			// If a user is logged in use that user and the note id to find the note
			try {
				$this->initialState->provideInitialState('huhu', [$note, $user->getUID()]);
				$noteData = $this->service->find($note, $user->getUID());
				$this->initialState->provideInitialState('initialNote', $noteData);
			} catch (NoteNotFound $e) {
				// Note not found, we might handle with some frontend message
			}
		}
		
		return new TemplateResponse(Application::APP_ID, 'main');
	}
}
