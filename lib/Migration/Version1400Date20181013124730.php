<?php

declare(strict_types=1);

namespace OCA\NotesTutorial\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

/**
 * Auto-generated migration step: Please modify to your needs!
 */
class Version1400Date20181013124730 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if (!$schema->hasTable('notestutorial')) {
			$table = $schema->createTable('notestutorial');
			$table->addColumn('id', 'bigint', [
				'autoincrement' => true,
				'notnull' => true,
				'length' => 8,
				'unsigned' => true,
			]);
			$table->addColumn('title', 'string', [
				'notnull' => true,
				'length' => 200,
				'default' => '',
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
				'default' => '',
			]);
			$table->addColumn('content', 'text', [
				'notnull' => true,
				'default' => '',
			]);
			$table->setPrimaryKey(['id']);
		}
		return $schema;
	}

}
