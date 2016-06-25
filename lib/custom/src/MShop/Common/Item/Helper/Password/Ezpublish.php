<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\MShop\Common\Item\Helper\Password;


/**
 * Ezpublish implementation of the password helper item
 *
 * @package MShop
 * @subpackage Common
 */
class Ezpublish implements \Aimeos\MShop\Common\Item\Helper\Password\Iface
{
	/**
	 * Returns the hashed password
	 *
	 * @param string $password Clear text password string
	 * @param string|null $salt Password salt
	 * @return string Hashed password
	 */
	public function encode( $password, $salt = null )
	{
		return md5( $salt . "\n" . $password );
	}
}
