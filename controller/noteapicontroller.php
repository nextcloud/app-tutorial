<?php
namespace OCA\OwnNotes\Controller;

use OCP\IRequest;
use OCP\AppFramework\ApiController;


class NoteApiController extends ApiController {

    private $controller;

    public function __construct($AppName, IRequest $request, NoteController $controller) {
        parent::__construct($AppName, $request);
        $this->controller = $controller;
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function index() {
        return $this->controller->index();
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param int $id
     */
    public function show($id) {
        return $this->controller->show($id);
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param string $title
     * @param string $content
     */
    public function create($title, $content) {
        return $this->controller->create($title, $content);
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param int $id
     * @param string $title
     * @param string $content
     */
    public function update($id, $title, $content) {
        return $this->controller->update($id, $title, $content);
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param int $id
     */
    public function destroy($id) {
        return $this->controller->destroy($id);
    }

}