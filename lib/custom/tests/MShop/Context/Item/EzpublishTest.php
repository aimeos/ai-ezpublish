<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2020
 */


namespace Aimeos\MShop\Context\Item;


class EzpublishTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp() : void
	{
		if( !interface_exists( 'eZ\Publish\API\Repository\UserService' ) ) {
			$this->markTestSkipped( 'Install ezsystems/ezpublish-api first' );
		}

		$this->mock = $this->getMockBuilder( 'eZ\Publish\API\Repository\UserService' )->getMock();
		$this->object = new \Aimeos\MShop\Context\Item\Ezpublish();
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testGetEzUserService()
	{
		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getEzUserService();
	}


	public function testSetEzUserService()
	{
		$return = $this->object->setEzUserService( $this->mock );

		$this->assertSame( $this->mock, $this->object->getEzUserService() );
		$this->assertInstanceOf( \Aimeos\MShop\Context\Item\Iface::class, $return );
	}
}
