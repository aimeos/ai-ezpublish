<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds ezPublish customer test data
 */
class CustomerAddEzpublishTestData extends \Aimeos\MW\Setup\Task\CustomerAddTestData
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies()
	{
		return array( 'TablesCreateEzpublish', 'EzuserAddAddress', 'MShopSetLocale', 'MediaAddTestData' );
	}


	/**
	 * Adds attribute test data.
	 */
	public function migrate()
	{
		$iface = '\\Aimeos\\MShop\\Context\\Item\\Iface';
		if( !( $this->additional instanceof $iface ) ) {
			throw new \Aimeos\MW\Setup\Exception( sprintf( 'Additionally provided object is not of type "%1$s"', $iface ) );
		}

		$context = $this->getEzContext( $this->additional );

		$this->msg( 'Adding ezPublish customer test data', 0 );

		$parentIds = array();
		$ds = DIRECTORY_SEPARATOR;
		$context->setEditor( 'ai-ezpublish:unittest' );
		$path = __DIR__ . $ds . 'data' . $ds . 'customer.php';

		if( ( $testdata = include( $path ) ) === false ){
			throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}


		$customerManager = \Aimeos\MShop\Customer\Manager\Factory::createManager( $context, 'Ezpublish' );
		$customerAddressManager = $customerManager->getSubManager( 'address', 'Ezpublish' );

		$search = $customerManager->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.code', array( 'UTC001', 'UTC002', 'UTC003' ) ) );
		$items = $customerManager->searchItems( $search );

		$this->conn->begin();

		$customerManager->deleteItems( array_keys( $items ) );
		$parentIds = $this->addCustomerData( $testdata, $customerManager, $customerAddressManager->createItem() );
		$this->addCustomerAddressData( $testdata, $customerAddressManager, $parentIds );

		$this->conn->commit();


		$this->status( 'done' );
	}


	/**
	 * Returns the Ezpublish context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Ezpublish Ezpublish context object
	 */
	protected function getEzContext( \Aimeos\MShop\Context\Item\Iface $context )
	{
		$class = '\Aimeos\MShop\Context\Item\Ezpublish';
		if( is_a( $context, $class ) ) {
			return $context;
		}

		$ezContext = new \Aimeos\MShop\Context\Item\Ezpublish();
		$ezContext->setDatabaseManager( clone $context->getDatabaseManager() );
		$ezContext->setSession( clone $context->getSession() );
		$ezContext->setLogger( clone $context->getLogger() );
		$ezContext->setLocale( clone $context->getLocale() );
		$ezContext->setConfig( clone $context->getConfig() );
		$ezContext->setCache( clone $context->getCache() );


		$ezContext->setEzUser( function( $code, $email, $password ) use ( $context ) {

			$id = mt_rand( -0x7fffffff,-1 );
			$dbm = $context->getDatabaseManager();
			$dbconf = $context->getConfig()->get( 'resource/db-customer' );
			$dbname = ( $dbconf ? 'db-customer' : 'db' );
			$conn = $dbm->acquire( $dbname );

			try
			{
				$stmt = $conn->create( 'INSERT INTO "ezuser" (
					"contentobject_id", "email", "login", "login_normalized", "password_hash", "password_hash_type"
				) VALUES (
					?, ?, ?, ?, ?, 5
				)' );

				$stmt->bind( 1, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$stmt->bind( 2, $email );
				$stmt->bind( 3, $code );
				$stmt->bind( 4, $code );
				$stmt->bind( 5, $password );

				$stmt->execute()->finish();

				$dbm->release( $conn, $dbname );
			}
			catch( \Exception $e )
			{
				$dbm->release( $conn, $dbname );
				throw $e;
			}

			return $id;
		} );


		return $ezContext;
	}
}
