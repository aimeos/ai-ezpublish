<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2020
 */


namespace Aimeos\MShop\Customer\Manager\Lists\Type;


class EzpublishTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp() : void
	{
		$manager = \Aimeos\MShop\Customer\Manager\Factory::create( \TestHelper::getContext(), 'Ezpublish' );

		$listManager = $manager->getSubManager( 'lists', 'Ezpublish' );
		$this->object = $listManager->getSubManager( 'type', 'Ezpublish' );
	}


	protected function tearDown() : void
	{
		unset( $this->object );
	}


	public function testClear()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->clear( array( -1 ) ) );
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
		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}
}
