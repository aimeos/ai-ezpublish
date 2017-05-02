<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */


namespace Aimeos\MShop\Customer\Manager\Group;


class EzpublishTest extends \PHPUnit\Framework\TestCase
{
	private $context;
	private $object;


	protected function setUp()
	{
		$this->context = \TestHelper::getContext();
		$customer = new \Aimeos\MShop\Customer\Manager\Ezpublish( $this->context );

		$this->object = $customer->getSubManager( 'group', 'Ezpublish' );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testCleanup()
	{
		$this->object->cleanup( array( -1 ) );
	}


	public function testDeleteItems()
	{
		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->deleteItems( array( -1 ) );
	}


	public function testGetSearchAttributes()
	{
		$attributes = $this->object->getSearchAttributes();
		$this->assertGreaterThan( 0, count( $attributes ) );

		foreach( $attributes as $attribute ) {
			$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Attribute\\Iface', $attribute );
		}
	}


	public function testGetSubManager()
	{
		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}


	public function testSaveItem()
	{
		$this->expectException( '\\Aimeos\\MShop\\Customer\\Exception' );
		$this->object->saveItem( new \Aimeos\MShop\Common\Item\Lists\Standard( 'common.lists.' ) );
	}


	public function testSearchItems()
	{
		$mock = $this->getMockBuilder( '\Aimeos\MShop\Customer\Manager\Group\Ezpublish' )
			->setConstructorArgs( array( \TestHelper::getContext() ) )
			->setMethods( array( 'searchItemsBase' ) )
			->getMock();

		$result = $this->getMockBuilder( '\Aimeos\MW\DB\Result\Iface' )
			->setMethods( array( 'affectedRows', 'fetch', 'finish', 'nextResult' ) )
			->getMock();

		$mock->expects( $this->once() )->method( 'searchItemsBase' )
			->will( $this->returnValue( $result ) );

		$result->expects( $this->exactly( 2 ) )->method( 'fetch' )
			->will( $this->onConsecutiveCalls( array( 'customer.group.id' => 1 ), false ) );

		$result = $mock->searchItems( $mock->createSearch() );

		$this->assertEquals( 1, count( $result ) );
		$this->assertInstanceOf( '\Aimeos\MShop\Customer\Item\Group\Iface', $result[1] );
	}


	public function testSearchItemsException()
	{
		$mock = $this->getMockBuilder( '\Aimeos\MShop\Customer\Manager\Group\Ezpublish' )
			->setConstructorArgs( array( \TestHelper::getContext() ) )
			->setMethods( array( 'searchItemsBase' ) )
			->getMock();

		$mock->expects( $this->once() )->method( 'searchItemsBase' )
			->will( $this->throwException( new \Aimeos\MShop\Exception() ) );

		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$mock->searchItems( $mock->createSearch() );
	}
}
