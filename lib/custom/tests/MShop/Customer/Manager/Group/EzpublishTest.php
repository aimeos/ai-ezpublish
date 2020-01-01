<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
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
		$this->object->clear( array( -1 ) );
	}


	public function testDeleteItems()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
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
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}


	public function testSaveItem()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Customer\\Exception' );
		$this->object->saveItem( new \Aimeos\MShop\Customer\Item\Group\Standard() );
	}


	public function testSearchItems()
	{
		$mock = $this->getMockBuilder( \Aimeos\MShop\Customer\Manager\Group\Ezpublish::class )
			->setConstructorArgs( array( \TestHelper::getContext() ) )
			->setMethods( array( 'searchItemsBase' ) )
			->getMock();

		$result = $this->getMockBuilder( \Aimeos\MW\DB\Result\Iface::class )
			->setMethods( array( 'affectedRows', 'fetch', 'finish', 'nextResult' ) )
			->getMock();

		$mock->expects( $this->once() )->method( 'searchItemsBase' )
			->will( $this->returnValue( $result ) );

		$result->expects( $this->exactly( 2 ) )->method( 'fetch' )
			->will( $this->onConsecutiveCalls( array( 'customer.group.id' => 1 ), null ) );

		$result = $mock->searchItems( $mock->createSearch() );

		$this->assertEquals( 1, count( $result ) );
		$this->assertInstanceOf( \Aimeos\MShop\Customer\Item\Group\Iface::class, $result[1] );
	}


	public function testSearchItemsException()
	{
		$mock = $this->getMockBuilder( \Aimeos\MShop\Customer\Manager\Group\Ezpublish::class )
			->setConstructorArgs( array( \TestHelper::getContext() ) )
			->setMethods( array( 'searchItemsBase' ) )
			->getMock();

		$mock->expects( $this->once() )->method( 'searchItemsBase' )
			->will( $this->throwException( new \Aimeos\MShop\Exception() ) );

		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$mock->searchItems( $mock->createSearch() );
	}
}
