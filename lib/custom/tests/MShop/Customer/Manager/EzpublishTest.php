<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 */


namespace Aimeos\MShop\Customer\Manager;


class EzpublishTest extends \PHPUnit\Framework\TestCase
{
	private $address;
	private $context;
	private $object;


	protected function setUp() : void
	{
		if( !interface_exists( 'eZ\Publish\API\Repository\UserService' ) ) {
			$this->markTestSkipped( 'Install ezsystems/ezpublish-api first' );
		}

		$this->context = \TestHelper::getContext();

		$this->object = new \Aimeos\MShop\Customer\Manager\Ezpublish( $this->context );
		$this->address = new \Aimeos\MShop\Common\Item\Address\Standard( 'common.address.' );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->context, $this->address );
	}


	public function testClear()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->clear( array( -1 ) ) );
	}


	public function testCreateItem()
	{
		$this->assertInstanceOf( 'Aimeos\MShop\Customer\Item\Iface', $this->object->createItem() );
	}


	public function testDeleteItems()
	{
		$mock = $this->getMockBuilder( 'eZ\Publish\API\Repository\UserService' )->getMock();
		$user = $this->getMockBuilder( 'eZ\Publish\API\Repository\Values\User\User' )->getMock();

		$mock->expects( $this->once() )->method( 'loadUser' )->will( $this->returnValue( $user ) );
		$mock->expects( $this->once() )->method( 'deleteUser' );

		$this->context->setEzUserService( $mock );
		$this->object->deleteItems( array( -1 ) );
	}


	public function testGetSearchAttributes()
	{
		$attributes = $this->object->getSearchAttributes();
		$this->assertGreaterThan( 0, count( $attributes ) );

		foreach( $attributes as $attribute ) {
			$this->assertInstanceOf( \Aimeos\MW\Criteria\Attribute\Iface::class, $attribute );
		}
	}


	public function testGetSubManager()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'address' ) );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'address', 'Standard' ) );

		$this->expectException( \Aimeos\MShop\Exception::class );
		$this->object->getSubManager( 'unknown' );
	}


	public function testGetSubManagerInvalidName()
	{
		$this->expectException( \Aimeos\MShop\Exception::class );
		$this->object->getSubManager( 'address', 'unknown' );
	}


	public function testSaveItemInsert()
	{
		$service = $this->getMockBuilder( 'eZ\Publish\API\Repository\UserService' )->getMock();
		$struct = $this->getMockBuilder( 'eZ\Publish\API\Repository\Values\User\UserCreateStruct' )->getMock();
		$user = $this->getMockBuilder( \eZ\Publish\API\Repository\Values\User\User::class )
			->setMethods( array( 'getUserId', 'getVersionInfo', 'getFieldValue', 'getFields', 'getFieldsByLanguage' ) )
			->getMock();

		$dbm = $this->getMockBuilder( 'Aimeos\MW\DB\Manager\Iface' )->getMock();
		$conn = $this->getMockBuilder( 'Aimeos\MW\DB\Connection\Iface' )->getMock();
		$stmt = $this->getMockBuilder( 'Aimeos\MW\DB\Statement\Iface' )->getMock();
		$result = $this->getMockBuilder( 'Aimeos\MW\DB\Result\Iface' )->getMock();

		$service->expects( $this->once() )->method( 'newUserCreateStruct' )->will( $this->returnValue( $struct ) );
		$service->expects( $this->once() )->method( 'createUser' )->will( $this->returnValue( $user ) );
		$user->expects( $this->once() )->method( 'getUserId' )->will( $this->returnValue( 1 ) );
		$dbm->expects( $this->once() )->method( 'acquire' )->will( $this->returnValue( $conn ) );
		$conn->expects( $this->once() )->method( 'create' )->will( $this->returnValue( $stmt ) );
		$stmt->expects( $this->once() )->method( 'execute' )->will( $this->returnValue( $result ) );


		$this->context->setDatabaseManager( $dbm );
		$this->context->setEzUserService( $service );

		$this->object->saveItem( new \Aimeos\MShop\Customer\Item\Standard( $this->address ) );
	}


	public function testSaveItemUpdate()
	{
		$service = $this->getMockBuilder( 'eZ\Publish\API\Repository\UserService' )->getMock();
		$user = $this->getMockBuilder( 'eZ\Publish\API\Repository\Values\User\User' )->getMock();
		$struct = $this->getMockBuilder( 'eZ\Publish\API\Repository\Values\User\UserUpdateStruct' )->getMock();
		$dbm = $this->getMockBuilder( 'Aimeos\MW\DB\Manager\Iface' )->getMock();
		$conn = $this->getMockBuilder( 'Aimeos\MW\DB\Connection\Iface' )->getMock();
		$stmt = $this->getMockBuilder( 'Aimeos\MW\DB\Statement\Iface' )->getMock();
		$result = $this->getMockBuilder( 'Aimeos\MW\DB\Result\Iface' )->getMock();

		$service->expects( $this->once() )->method( 'updateUser' );
		$service->expects( $this->once() )->method( 'loadUser' )->will( $this->returnValue( $user ) );
		$service->expects( $this->once() )->method( 'newUserUpdateStruct' )->will( $this->returnValue( $struct ) );
		$dbm->expects( $this->once() )->method( 'acquire' )->will( $this->returnValue( $conn ) );
		$conn->expects( $this->once() )->method( 'create' )->will( $this->returnValue( $stmt ) );
		$stmt->expects( $this->once() )->method( 'execute' )->will( $this->returnValue( $result ) );
		$result->expects( $this->once() )->method( 'finish' );
		$dbm->expects( $this->once() )->method( 'release' );


		$item = new \Aimeos\MShop\Customer\Item\Standard( $this->address, array( 'customer.id' => 1 ) );
		$item->setCode( 'test' );

		$this->context->setDatabaseManager( $dbm );
		$this->context->setEzUserService( $service );
		$this->object->saveItem( $item );
	}


	public function testSaveItemNotModified()
	{
		$item = new \Aimeos\MShop\Customer\Item\Standard( $this->address, array( 'customer.id' => 1 ) );
		$this->object->saveItem( $item );
	}


	public function testSaveItemInvalidContext()
	{
		$context = new \Aimeos\MShop\Context\Item\Standard();
		$context->setConfig( $this->context->getConfig() );
		$context->setLocale( $this->context->getLocale() );

		$object = new \Aimeos\MShop\Customer\Manager\Ezpublish( $context );

		$this->expectException( \Aimeos\MShop\Customer\Exception::class );
		$object->saveItem( new \Aimeos\MShop\Customer\Item\Standard( $this->address ) );
	}


	public function testSearchItems()
	{
		$mock = $this->getMockBuilder( \Aimeos\MShop\Customer\Manager\Ezpublish::class )
			->setConstructorArgs( array( $this->context ) )
			->setMethods( array( 'searchItemsBase' ) )
			->getMock();

		$result1 = $this->getMockBuilder( \Aimeos\MW\DB\Result\Iface::class )->getMock();

		$mock->expects( $this->once() )->method( 'searchItemsBase' )->will( $this->returnValue( $result1 ) );
		$result1->expects( $this->exactly( 2 ) )->method( 'fetch' )
			->will( $this->onConsecutiveCalls( array( 'customer.id' => -1 ), null ) );


		$dbm = $this->getMockBuilder( 'Aimeos\MW\DB\Manager\Iface' )->getMock();
		$conn = $this->getMockBuilder( 'Aimeos\MW\DB\Connection\Iface' )->getMock();
		$stmt = $this->getMockBuilder( 'Aimeos\MW\DB\Statement\Iface' )->getMock();
		$result2 = $this->getMockBuilder( \Aimeos\MW\DB\Result\Iface::class )->getMock();

		$dbm->expects( $this->any() )->method( 'acquire' )->will( $this->returnValue( $conn ) );
		$conn->expects( $this->once() )->method( 'create' )->will( $this->returnValue( $stmt ) );
		$stmt->expects( $this->once() )->method( 'execute' )->will( $this->returnValue( $result2 ) );
		$result2->expects( $this->exactly( 2 ) )->method( 'fetch' )
			->will( $this->onConsecutiveCalls( array( 'contentobject_id' => -1, 'role_id' => -2 ), null ) );

		$dbm->expects( $this->any() )->method( 'release' );


		$this->context->setDatabaseManager( $dbm );
		$list = $mock->searchItems( $mock->createSearch() );

		$this->assertEquals( 1, count( $list ) );
		$this->assertInstanceOf( \Aimeos\MShop\Customer\Item\Iface::class, $list[-1] );
	}


	public function testSearchItemsException()
	{
		$object = $this->getMockBuilder( \Aimeos\MShop\Customer\Manager\Ezpublish::class )
			->setConstructorArgs( array( $this->context ) )
			->setMethods( array( 'searchItemsBase' ) )
			->getMock();

		$object->expects( $this->once() )->method( 'searchItemsBase' )
			->will( $this->throwException( new \Aimeos\MShop\Exception() ) );

		$this->expectException( \Aimeos\MShop\Exception::class );
		$object->searchItems( $object->createSearch() );
	}
}
