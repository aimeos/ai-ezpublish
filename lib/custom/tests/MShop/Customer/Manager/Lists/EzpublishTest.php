<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 */


namespace Aimeos\MShop\Customer\Manager\Lists;


class EzpublishTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp()
	{
		$manager = \Aimeos\MShop\Customer\Manager\Factory::createManager( \TestHelper::getContext(), 'Ezpublish' );
		$this->object = $manager->getSubManager( 'lists', 'Ezpublish' );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testCleanup()
	{
		$this->object->cleanup( array( -1 ) );
	}


	public function testGetSearchAttributes()
	{
		$attributes = $this->object->getSearchAttributes();
		$this->assertGreaterThan( 0, count( $attributes ) );

		foreach( $attributes as $attribute ) {
			$this->assertInstanceOf( '\Aimeos\MW\Criteria\Attribute\Iface', $attribute );
		}
	}


	public function testGetSubManager()
	{
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Manager\\Iface', $this->object->getSubManager('type') );
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Manager\\Iface', $this->object->getSubManager('type', 'Standard') );

		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}


	public function testSaveItemInvalidItem()
	{
		$this->setExpectedException( '\Aimeos\MW\Common\Exception' );
		$this->object->saveItem( new \Aimeos\MShop\Common\Item\Type\Standard( 'common.lists.type.' ) );
	}


	public function testSaveItemInvalidDomain()
	{
		$item = $this->object->createItem();
		$item->setDomain( 'customer/group' );

		$this->setExpectedException( '\Aimeos\MShop\Customer\Exception' );
		$this->object->saveItem( $item );
	}
}
