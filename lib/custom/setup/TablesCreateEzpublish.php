<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Creates all required tables.
 */
class TablesCreateEzpublish extends \Aimeos\MW\Setup\Task\TablesCreateMShop
{
	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies()
	{
		return array( 'MShopAddTypeData' );
	}


	/**
	 * Migrate database schema
	 */
	public function migrate()
	{
		$this->msg( 'Creating Aimeos ezPublish tables', 0 );
		$this->status( '' );

		$ds = DIRECTORY_SEPARATOR;

		$files = array(
			'db-customer' => __DIR__ . $ds . 'default' . $ds . 'schema' . $ds . 'customer.php',
		);

		$this->setupSchema( $files );
	}
}
