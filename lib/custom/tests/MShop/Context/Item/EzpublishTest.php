<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */


namespace Aimeos\MShop\Context\Item;


class EzpublishTest extends \PHPUnit_Framework_TestCase
{
	private $object;


	protected function setUp()
	{
		$this->object = new \Aimeos\MShop\Context\Item\Ezpublish();
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testGetEzUser()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getEzUser();
	}


	public function testSetEzUser()
	{
		$closure = function() {};
		$return = $this->object->setEzUser( $closure );

		$this->assertSame( $closure, $this->object->getEzUser() );
		$this->assertInstanceOf( '\Aimeos\MShop\Context\Item\Iface', $return );
	}
}