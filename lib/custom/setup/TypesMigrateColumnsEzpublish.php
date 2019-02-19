<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds the new type columns
 */
class TypesMigrateColumnsEzpublish extends \Aimeos\MW\Setup\Task\TypesMigrateColumns
{
	private $tables = [
		'db-customer' => ['ezuser_list', 'ezuser_property'],
	];

	private $constraints = [
		'db-customer' => ['ezuser_list' => 'unq_ezpli_sid_dm_rid_tid_pid', 'ezuser_property' => 'unq_ezppr_sid_tid_lid_value'],
	];

	private $migrations = [
		'db-customer' => [
			'ezuser_list' => 'UPDATE "ezuser_list" SET "type" = ( SELECT "code" FROM "ezuser_list_type" AS t WHERE t."id" = "typeid" AND t."domain" = "domain" LIMIT 1 ) WHERE "type" IS NULL',
			'ezuser_property' => 'UPDATE "ezuser_property" SET "type" = ( SELECT "code" FROM "ezuser_property_type" AS t WHERE t."id" = "typeid" AND t."domain" = "domain" LIMIT 1 ) WHERE "type" IS NULL',
		],
	];


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies()
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Executes the task
	 */
	public function migrate()
	{
		$this->msg( sprintf( 'Add new type columns for FosUser' ), 0 );
		$this->status( '' );

		foreach( $this->tables as $rname => $list ) {
			$this->addColumn( $rname, $list );
		}

		$this->msg( sprintf( 'Drop old unique indexes for FosUser' ), 0 );
		$this->status( '' );

		foreach( $this->constraints as $rname => $list ) {
			$this->dropIndex( $rname, $list );
		}

		$this->msg( sprintf( 'Migrate typeid to type for FosUser' ), 0 );
		$this->status( '' );

		foreach( $this->migrations as $rname => $list ) {
			$this->migrateData( $rname, $list );
		}
	}
}
