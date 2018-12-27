<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 */


namespace Aimeos\MShop\Customer\Manager\Property\Type;


class EzpublishTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp()
	{
		$manager = \Aimeos\MShop\Customer\Manager\Factory::create( \TestHelper::getContext(), 'Ezpublish' );

		$listManager = $manager->getSubManager( 'property', 'Ezpublish' );
		$this->object = $listManager->getSubManager( 'type', 'Ezpublish' );
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
			$this->assertInstanceOf( \Aimeos\MW\Criteria\Attribute\Iface::class, $attribute );
		}
	}


	public function testGetSubManager()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}
}
