<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Property\Type;


/**
 * Default customer property type manager
 *
 * @package MShop
 * @subpackage Customer
 */
class Ezpublish
	extends \Aimeos\MShop\Customer\Manager\Property\Type\Standard
{
	private $searchConfig = array(
		'customer.property.type.id' => array(
			'code' => 'customer.property.type.id',
			'internalcode' => 'ezpprty."id"',
			'label' => 'Property type ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.property.type.siteid' => array(
			'code' => 'customer.property.type.siteid',
			'internalcode' => 'ezpprty."siteid"',
			'label' => 'Property type site ID',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.property.type.label' => array(
			'code' => 'customer.property.type.label',
			'internalcode' => 'ezpprty."label"',
			'label' => 'Property type label',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.property.type.code' => array(
			'code' => 'customer.property.type.code',
			'internalcode' => 'ezpprty."code"',
			'label' => 'Property type code',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.property.type.domain' => array(
			'code' => 'customer.property.type.domain',
			'internalcode' => 'ezpprty."domain"',
			'label' => 'Property type domain',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.property.type.position' => array(
			'code' => 'customer.property.type.position',
			'internalcode' => 'ezpprty."pos"',
			'label' => 'Property type position',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.property.type.status' => array(
			'code' => 'customer.property.type.status',
			'internalcode' => 'ezpprty."status"',
			'label' => 'Property type status',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.property.type.ctime' => array(
			'code' => 'customer.property.type.ctime',
			'internalcode' => 'ezpprty."ctime"',
			'label' => 'Property type create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.property.type.mtime' => array(
			'code' => 'customer.property.type.mtime',
			'internalcode' => 'ezpprty."mtime"',
			'label' => 'Property type modify date',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.property.type.editor' => array(
			'code' => 'customer.property.type.editor',
			'internalcode' => 'ezpprty."editor"',
			'label' => 'Property type editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
	);


	/**
	 * Removes old entries from the storage.
	 *
	 * @param string[] $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Common\Manager\Iface Same object for fluent interface
	 */
	public function clear( array $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/property/type/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, [] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/customer/manager/property/type/ezpublish/delete' );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return array Returns a list of attribtes implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$path = 'mshop/customer/manager/property/type/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for customer type extensions.
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g types, lists etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'customer', 'property/type/' . $manager, ( $name === null ? 'Ezpublish' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path
	 */
	protected function getConfigPath() : string
	{
		return 'mshop/customer/manager/property/type/ezpublish/';
	}


	/**
	 * Returns the search configuration for searching items.
	 *
	 * @return array Associative list of search keys and search definitions
	 */
	protected function getSearchConfig() : array
	{
		return $this->searchConfig;
	}
}
