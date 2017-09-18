<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2017
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Lists;


/**
 * ezPublish implementation of the customer list class
 *
 * @package MShop
 * @subpackage Customer
 */
class Ezpublish
	extends \Aimeos\MShop\Customer\Manager\Lists\Standard
	implements \Aimeos\MShop\Customer\Manager\Lists\Iface, \Aimeos\MShop\Common\Manager\Lists\Iface
{
	private $searchConfig = array(
		'customer.lists.id'=> array(
			'code'=>'customer.lists.id',
			'internalcode'=>'ezuli."id"',
			'internaldeps' => array( 'LEFT JOIN "ezuser_list" AS ezuli ON ( ezu."id" = ezuli."parentid" )' ),
			'label'=>'Customer list ID',
			'type'=> 'integer',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.siteid'=> array(
			'code'=>'customer.lists.siteid',
			'internalcode'=>'ezuli."siteid"',
			'label'=>'Customer list site ID',
			'type'=> 'integer',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.parentid'=> array(
			'code'=>'customer.lists.parentid',
			'internalcode'=>'ezuli."parentid"',
			'label'=>'Customer list parent ID',
			'type'=> 'integer',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.domain'=> array(
			'code'=>'customer.lists.domain',
			'internalcode'=>'ezuli."domain"',
			'label'=>'Customer list domain',
			'type'=> 'string',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.typeid' => array(
			'code'=>'customer.lists.typeid',
			'internalcode'=>'ezuli."typeid"',
			'label'=>'Customer list type ID',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.refid'=> array(
			'code'=>'customer.lists.refid',
			'internalcode'=>'ezuli."refid"',
			'label'=>'Customer list reference ID',
			'type'=> 'string',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.datestart' => array(
			'code'=>'customer.lists.datestart',
			'internalcode'=>'ezuli."start"',
			'label'=>'Customer list start date/time',
			'type'=> 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.dateend' => array(
			'code'=>'customer.lists.dateend',
			'internalcode'=>'ezuli."end"',
			'label'=>'Customer list end date/time',
			'type'=> 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.config' => array(
			'code'=>'customer.lists.config',
			'internalcode'=>'ezuli."config"',
			'label'=>'Customer list position',
			'type'=> 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.position' => array(
			'code'=>'customer.lists.position',
			'internalcode'=>'ezuli."pos"',
			'label'=>'Customer list position',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.lists.status' => array(
			'code'=>'customer.lists.status',
			'internalcode'=>'ezuli."status"',
			'label'=>'Customer list status',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.lists.ctime'=> array(
			'code'=>'customer.lists.ctime',
			'internalcode'=>'ezuli."ctime"',
			'label'=>'Customer list create date/time',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.mtime'=> array(
			'code'=>'customer.lists.mtime',
			'internalcode'=>'ezuli."mtime"',
			'label'=>'Customer list modification date/time',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.editor'=> array(
			'code'=>'customer.lists.editor',
			'internalcode'=>'ezuli."editor"',
			'label'=>'Customer list editor',
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
		$path = 'mshop/customer/manager/lists/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, array( 'type' ) ) as $domain ) {
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
		$path = 'mshop/customer/manager/lists/submanagers';

		return $this->getSearchAttributesBase( $this->getSearchConfig(), $path, array( 'type' ), $withsub );
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
		return $this->getSubManagerBase( 'customer', 'lists/' . $manager, ( $name === null ? 'Ezpublish' : $name ) );
	}


	/**
	 * Updates or adds a common list item object.
	 *
	 * @param \Aimeos\MShop\Common\Item\Lists\Iface $item List item object which should be saved
	 * @param boolean $fetch True if the new ID should be returned in the item
	 */
	public function saveItem( \Aimeos\MShop\Common\Item\Iface $item, $fetch = true )
	{
		$iface = '\\Aimeos\\MShop\\Common\\Item\\Lists\\Iface';
		if( !( $item instanceof $iface ) ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'Object is not of required type "%1$s"', $iface ) );
		}

		if( $item->getDomain() === 'customer/group' ) {
			throw new \Aimeos\MShop\Customer\Exception( sprintf( 'Adding groups to customers is not supported, please use the eZ Publish backend' ) );
		}

		parent::saveItem( $item, $fetch );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path (mshop/customer/manager/lists/ezpublish/)
	 */
	protected function getConfigPath()
	{
		return 'mshop/customer/manager/lists/ezpublish/';
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
