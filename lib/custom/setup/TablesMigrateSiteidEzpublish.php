<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Updates site ID columns
 */
class TablesMigrateSiteidEzpublish extends TablesMigrateSiteid
{
	private $resources = [
		'db-customer' => [
			'ezuser_list_type', 'ezuser_property_type',
			'ezuser_property', 'ezuser_list', 'ezuser_address', 'ezuser',
		],
	];


	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['TablesMigrateSiteid'];
	}


	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies() : array
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Executes the task
	 */
	public function migrate()
	{
		$this->msg( 'Update eZPublish "siteid" columns', 0, '' );

		$this->process( $this->resources );
	}
}
