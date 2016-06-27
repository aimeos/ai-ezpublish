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
	private $ezUserService;


	/**
	 * Sets the eZ user service object
	 *
	 * @param \eZ\Publish\API\Repository\UserService $service eZ user service object
	 * @return \Aimeos\MShop\Context\Item\Iface Context item for chaining method calls
	 */
	public function setEzUserService( \eZ\Publish\API\Repository\UserService $service )
	{
		$this->ezUserService = $service;
		return $this;
	}


	/**
	 * Returns the eZ user service object
	 *
	 * @return \eZ\Publish\API\Repository\UserService eZ user service object
	 */
	public function getEzUserService()
	{
		if( !isset( $this->ezUserService ) ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'eZ user service not available' ) );
		}

		return $this->ezUserService;
	}
}
