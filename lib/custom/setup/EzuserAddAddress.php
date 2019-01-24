<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds the required address fields to ezuser table
 */
class EzuserAddAddress extends \Aimeos\MW\Setup\Task\Base
{
	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPreDependencies()
	{
		return array( 'TablesCreateEzpublish' );
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies()
	{
		return [];
	}


	/**
	 * Migrate database schema
	 */
	public function migrate()
	{
		$this->msg( 'Adding address fields to ezuser table', 0 );

		$conn = $this->acquire( 'db-customer' );
		$dbal = $conn->getRawObject();

		if( !( $dbal instanceof \Doctrine\DBAL\Connection ) ) {
			throw new \Aimeos\MW\Setup\Exception( 'Not a DBAL connection' );
		}

		$fromSchema = $dbal->getSchemaManager()->createSchema();
		$toSchema = clone $fromSchema;

		$this->addIndexes( $this->addColumns( $toSchema->getTable( 'ezuser' ) ) );
		$sql = $fromSchema->getMigrateToSql( $toSchema, $dbal->getDatabasePlatform() );

		$this->release( $conn, 'db-customer' );

		if( $sql !== [] )
		{
			$this->executeList( $sql, 'db-customer' );
			$this->status( 'done' );
		}
		else
		{
			$this->status( 'OK' );
		}
	}


	/**
	 * Adds the missing columns to the table
	 *
	 * @param \Doctrine\DBAL\Schema\Table $table Table object
	 * @return \Doctrine\DBAL\Schema\Table Updated table object
	 */
	protected function addColumns( \Doctrine\DBAL\Schema\Table $table )
	{
		$columns = array(
			'company' => array( 'string', array( 'length' => 100 ) ),
			'vatid' => array( 'string', array( 'length' => 32 ) ),
			'salutation' => array( 'string', array( 'length' => 8 ) ),
			'title' => array( 'string', array( 'length' => 64 ) ),
			'firstname' => array( 'string', array( 'length' => 64 ) ),
			'lastname' => array( 'string', array( 'length' => 64 ) ),
			'address1' => array( 'string', array( 'length' => 255 ) ),
			'address2' => array( 'string', array( 'length' => 255 ) ),
			'address3' => array( 'string', array( 'length' => 255 ) ),
			'postal' => array( 'string', array( 'length' => 16 ) ),
			'city' => array( 'string', array( 'length' => 255 ) ),
			'state' => array( 'string', array( 'length' => 255 ) ),
			'langid' => array( 'string', array( 'length' => 5, 'notnull' => false ) ),
			'countryid' => array( 'string', array( 'length' => 2, 'notnull' => false ) ),
			'telephone' => array( 'string', array( 'length' => 32 ) ),
			'telefax' => array( 'string', array( 'length' => 32 ) ),
			'website' => array( 'string', array( 'length' => 255 ) ),
			'birthday' => array( 'date', array( 'notnull' => false ) ),
			'vdate' => array( 'date', array( 'notnull' => false ) ),
			'status' => array( 'smallint', [] ),
			'mtime' => array( 'datetime', [] ),
			'ctime' => array( 'datetime', [] ),
			'editor' => array( 'string', array( 'length' => 255 ) ),
		);

		foreach( $columns as $name => $def )
		{
			if( $table->hasColumn( $name ) === false ) {
				$table->addColumn( $name, $def[0], $def[1] );
			}
		}

		return $table;
	}


	/**
	 * Adds the missing indexes to the table
	 *
	 * @param \Doctrine\DBAL\Schema\Table $table Table object
	 * @return \Doctrine\DBAL\Schema\Table Updated table object
	 */
	protected function addIndexes( \Doctrine\DBAL\Schema\Table $table )
	{
		$indexes = array(
			'idx_ezpus_langid' => array( 'langid' ),
			'idx_ezpus_status_ln_fn' => array( 'status', 'lastname', 'firstname' ),
			'idx_ezpus_status_ad1_ad2' => array( 'status', 'address1', 'address2' ),
			'idx_ezpus_status_postal_city' => array( 'status', 'postal', 'city' ),
			'idx_ezpus_lastname' => array( 'lastname' ),
			'idx_ezpus_address1' => array( 'address1' ),
			'idx_ezpus_postal' => array( 'postal' ),
			'idx_ezpus_city' => array( 'city' ),
		);

		foreach( $indexes as $name => $def )
		{
			if( $table->hasIndex( $name ) === false ) {
				$table->addIndex( $def, $name );
			}
		}

		return $table;
	}
}
