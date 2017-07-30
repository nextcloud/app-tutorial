<?php
namespace OCA\NotesTutorial\Db;

use OCP\IDb;
use OCP\AppFramework\Db\Mapper;

class NoteMapper extends Mapper {

    public function __construct(IDb $db) {
        parent::__construct($db, 'notestutorial', '\OCA\NotesTutorial\Db\Note');
    }

    public function find(int $id, string $userId): Note {
        $sql = 'SELECT * FROM *PREFIX*notestutorial WHERE id = ? AND user_id = ?';
        return $this->findEntity($sql, [$id, $userId]);
    }

    public function findAll(string $userId): array {
        $sql = 'SELECT * FROM *PREFIX*notestutorial WHERE user_id = ?';
        return $this->findEntities($sql, [$userId]);
    }

}