<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
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
	private $password = '';
	private $helper;


	/**
	 * Initializes the customer item object
	 *
	 * @param \Aimeos\MShop\Common\Item\Address\Iface $address Payment address item object
	 * @param array $values List of attributes that belong to the customer item
	 * @param \Aimeos\MShop\Common\Lists\Item\Iface[] $listItems List of list items
	 * @param \Aimeos\MShop\Common\Item\Iface[] $refItems List of referenced items
	 * @param string $salt Password salt (optional)
	 * @param \Aimeos\MShop\Common\Item\Helper\Password\Iface|null $helper Password encryption helper object
	 */
	public function __construct( \Aimeos\MShop\Common\Item\Address\Iface $address, array $values = array(),
		array $listItems = array(), array $refItems = array(), $salt = '',
		\Aimeos\MShop\Common\Item\Helper\Password\Iface $helper = null )
	{
		parent::__construct( $address, $values, $listItems, $refItems );

		if( isset( $values['customer.password'] ) ) {
			$this->password = $values['customer.password'];
		}

		$this->helper = $helper;
	}


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
		if( $value == $this->getPassword() ) { return $this; }

		if( $this->helper !== null ) {
			$value = $this->helper->encode( $value, $this->getCode() );
		}

		$this->password = (string) $value;
		$this->setModified();

		return $this;
	}
}
