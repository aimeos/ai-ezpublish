<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 * @package MShop
 * @subpackage Context
 */


namespace Aimeos\MShop\Context\Item;


/**
 * Common objects which must to be available for all manager objects
 *
 * @package MShop
 * @subpackage Context
 */
class Ezpublish extends \Aimeos\MShop\Context\Item\Standard
{
	private $ezUser;


	/**
	 * Sets the user creating function
	 *
	 * @param \Closure $userfcn Function to create a new user and return its ID
	 * @return \Aimeos\MShop\Context\Item\Iface Context item for chaining method calls
	 */
	public function setEzUser( \Closure $userfcn )
	{
		$this->ezUser = $userfcn;
		return $this;
	}


	/**
	 * Returns the user creating function
	 *
	 * @return \Closure Function to create a new user and return its ID
	 */
	public function getEzUser()
	{
		if( !isset( $this->ezUser ) ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'eZ user function not available' ) );
		}

		return $this->ezUser;
	}
}
