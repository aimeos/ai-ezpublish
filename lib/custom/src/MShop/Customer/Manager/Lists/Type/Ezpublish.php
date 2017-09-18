<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2017
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Lists\Type;


/**
 * ezPublish implementation of the customer list type class.
 *
 * @package MShop
 * @subpackage Customer
 */
class Ezpublish
	extends \Aimeos\MShop\Customer\Manager\Lists\Type\Standard
	implements \Aimeos\MShop\Customer\Manager\Lists\Type\Iface
{
	private $searchConfig = array(
		'customer.lists.type.id' => array(
			'code'=>'customer.lists.type.id',
			'internalcode'=>'ezulity."id"',
			'internaldeps'=>array( 'LEFT JOIN "ezuser_list_type" AS ezulity ON ( ezuli."typeid" = ezulity."id" )' ),
			'label'=>'Customer list type ID',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.type.siteid' => array(
			'code'=>'customer.lists.type.siteid',
			'internalcode'=>'ezulity."siteid"',
			'label'=>'Customer list type site ID',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.type.code' => array(
			'code'=>'customer.lists.type.code',
			'internalcode'=>'ezulity."code"',
			'label'=>'Customer list type code',
			'type'=> 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.domain' => array(
			'code'=>'customer.lists.type.domain',
			'internalcode'=>'ezulity."domain"',
			'label'=>'Customer list type domain',
			'type'=> 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.label' => array(
			'code'=>'customer.lists.type.label',
			'internalcode'=>'ezulity."label"',
			'label'=>'Customer list type label',
			'type'=> 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.status' => array(
			'code'=>'customer.lists.type.status',
			'internalcode'=>'ezulity."status"',
			'label'=>'Customer list type status',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.lists.type.ctime'=> array(
			'code'=>'customer.lists.type.ctime',
			'internalcode'=>'ezulity."ctime"',
			'label'=>'Customer list type create date/time',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.mtime'=> array(
			'code'=>'customer.lists.type.mtime',
			'internalcode'=>'ezulity."mtime"',
			'label'=>'Customer list type modification date/time',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.editor'=> array(
			'code'=>'customer.lists.type.editor',
			'internalcode'=>'ezulity."editor"',
			'label'=>'Customer list type editor',
			'type'=> 'string',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
	);


	/**
	 * Removes old entries from the storage.
	 *
	 * @param array $siteids List of IDs for sites whose entries should be deleted
	 */
	public function cleanup( array $siteids )
	{
		$path = 'mshop/customer/manager/lists/type/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, [] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->cleanup( $siteids );
		}

		$this->cleanupBase( $siteids, $this->getConfigPath() . 'delete' );
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'mshop/customer/manager/lists/type/submanagers';

		return $this->getSearchAttributesBase( $this->getSearchConfig(), $path, [], $withsub );
	}


	/**
	 * Returns a new manager for customer extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return mixed Manager for different extensions, e.g stock, tags, locations, etc.
	 */
	public function getSubManager( $manager, $name = null )
	{
		return $this->getSubManagerBase( 'customer', 'lists/type/' . $manager, ( $name === null ? 'Ezpublish' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path (mshop/customer/manager/lists/type/ezpublish/)
	 */
	protected function getConfigPath()
	{
		return 'mshop/customer/manager/lists/type/ezpublish/';
	}


	/**
	 * Returns the search configuration for searching items.
	 *
	 * @return array Associative list of search keys and search definitions
	 */
	protected function getSearchConfig()
	{
		return $this->searchConfig;
	}
}
