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

		$ctx = new \Aimeos\MShop\Context\Item\Ezpublish();
		$ctx->setDatabaseManager( clone $context->getDatabaseManager() );
		$ctx->setSession( clone $context->getSession() );
		$ctx->setLogger( clone $context->getLogger() );
		$ctx->setLocale( clone $context->getLocale() );
		$ctx->setConfig( clone $context->getConfig() );
		$ctx->setCache( clone $context->getCache() );


		$ctx->setEzUser( function( $id, $code, $email, $password, $status ) use ( $ctx ) {

			$dbm = $ctx->getDatabaseManager();
			$dbname = ( $ctx->getConfig()->get( 'resource/db-customer' ) ? 'db-customer' : 'db' );
			$conn = $dbm->acquire( $dbname );

			try
			{
				$contentid = ( $id === null ? mt_rand( -0x7fffffff,-1 ) : $id );

				if( $id === null ) {
					$sql = 'INSERT INTO "ezuser" ( "email", "login", "login_normalized", "password_hash", "password_hash_type", "contentobject_id" ) VALUES ( ?, ?, ?, ?, 5, ? )';
				} else {
					$sql = 'UPDATE "ezuser" SET "email" = ?, "login" = ?, "login_normalized" = ?, "password_hash" = ?, "password_hash_type" = 5 WHERE "contentobject_id" = ?';
				}

				$stmt = $conn->create( $sql );
				$stmt->bind( 1, $email );
				$stmt->bind( 2, $code );
				$stmt->bind( 3, $code );
				$stmt->bind( 4, $password );
				$stmt->bind( 5, $contentid, \Aimeos\MW\DB\Statement\Base::PARAM_INT );

				$stmt->execute()->finish();


				if( $id === null ) {
					$sql = 'INSERT INTO "ezuser_setting" ( "is_enabled", "user_id" ) VALUES ( ?, ? )';
				} else {
					$sql = 'UPDATE "ezuser_setting" SET "is_enabled" = ? WHERE "user_id" = ?';
				}

				$stmt = $conn->create( $sql );
				$stmt->bind( 1, $status, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$stmt->bind( 2, $contentid, \Aimeos\MW\DB\Statement\Base::PARAM_INT );

				$stmt->execute()->finish();


				$dbm->release( $conn, $dbname );
			}
			catch( \Exception $e )
			{
				$dbm->release( $conn, $dbname );
				throw $e;
			}

			return $contentid;
		} );


		return $ctx;
	}
}
