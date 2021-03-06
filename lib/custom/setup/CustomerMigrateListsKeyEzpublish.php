<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019-2020
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Updates key columns
 */
class CustomerMigrateListsKeyEzpublish extends TablesMigrateListsKey
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['TablesMigrateListsKey'];
	}


	/**
	 * Executes the task
	 */
	public function migrate()
	{
		$this->msg( 'Update eZ Publish lists "key" columns', 0 ); $this->status( '' );

		$this->process( ['db-customer' => 'ezuser_list'] );
	}
}
