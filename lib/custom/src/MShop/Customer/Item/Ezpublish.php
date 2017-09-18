<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Item;


/**
 * Ezpublish customer item
 *
 * @package MShop
 * @subpackage Customer
 */
class Ezpublish extends Standard implements Iface
{
	private $password = null;


	/**
	 * Returns the password of the customer item
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}


	/**
	 * Sets the password of the customer item
	 *
	 * @param string $value password of the customer item
	 * @return \Aimeos\MShop\Customer\Item\Iface Customer item for chaining method calls
	 */
	public function setPassword( $value )
	{
		if( $value !== '' && $value != $this->getPassword() )
		{
			$this->password = (string) $value;
			$this->setModified();
		}

		return $this;
	}
}
