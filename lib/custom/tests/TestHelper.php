<?php


/**
 * @copyright Metaways Infosystems GmbH, 2011
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */
class TestHelper
{
	private static $aimeos;
	private static $context = array();


	public static function bootstrap()
	{
		$aimeos = self::getAimeos();

		$includepaths = $aimeos->getIncludePaths();
		$includepaths[] = get_include_path();
		set_include_path( implode( PATH_SEPARATOR, $includepaths ) );
	}


	public static function getContext( $site = 'unittest' )
	{
		if( !isset( self::$context[$site] ) ) {
			self::$context[$site] = self::createContext( $site );
		}

		return clone self::$context[$site];
	}


	private static function getAimeos()
	{
		if( !isset( self::$aimeos ) )
		{
			require_once 'Bootstrap.php';
			spl_autoload_register( 'Aimeos\\Bootstrap::autoload' );

			$extdir = dirname( dirname( dirname( __DIR__ ) ) );
			self::$aimeos = new \Aimeos\Bootstrap( array( $extdir ), true );
		}

		return self::$aimeos;
	}


	/**
	 * @param string $site
	 */
	private static function createContext( $site )
	{
		$ctx = new \Aimeos\MShop\Context\Item\Ezpublish();
		$aimeos = self::getAimeos();


		$paths = $aimeos->getConfigPaths();
		$paths[] = __DIR__ . DIRECTORY_SEPARATOR . 'config';

		$conf = new \Aimeos\MW\Config\PHPArray( array(), $paths );
		$ctx->setConfig( $conf );


		$dbm = new \Aimeos\MW\DB\Manager\DBAL( $conf );
		$ctx->setDatabaseManager( $dbm );


		$logger = new \Aimeos\MW\Logger\File( $site . '.log', \Aimeos\MW\Logger\Base::DEBUG );
		$ctx->setLogger( $logger );


		$cache = new \Aimeos\MW\Cache\None();
		$ctx->setCache( $cache );


		$i18n = new \Aimeos\MW\Translation\None( 'de' );
		$ctx->setI18n( array( 'de' => $i18n ) );


		$session = new \Aimeos\MW\Session\None();
		$ctx->setSession( $session );


		$localeManager = \Aimeos\MShop\Locale\Manager\Factory::createManager( $ctx );
		$localeItem = $localeManager->bootstrap( $site, '', '', false );

		$ctx->setLocale( $localeItem );

		$ctx->setEditor( 'ai-ezpublish:unittest' );


		$ctx->setEzUser( function( $code, $email, $password ) use ( $ctx ) {

			$id = mt_rand( -0x7fffffff,-1 );
			$dbm = $ctx->getDatabaseManager();
			$dbconf = $ctx->getConfig()->get( 'resource/db-customer' );
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

				$sql = 'INSERT INTO "ezuser_setting" ( "user_id", "is_enabled", "max_login" ) VALUES ( ?, ?, ? )';
				$stmt = $conn->create( $sql );

				$stmt->bind( 1, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$stmt->bind( 2, 0 );
				$stmt->bind( 3, 10 );

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


		return $ctx;
	}
}
