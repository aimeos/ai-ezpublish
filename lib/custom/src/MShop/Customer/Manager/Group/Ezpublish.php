<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2017
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Group;


/**
 * eZPublish implementation of the customer group class
 *
 * @package MShop
 * @subpackage Customer
 */
class Ezpublish
	extends \Aimeos\MShop\Customer\Manager\Group\Standard
	implements \Aimeos\MShop\Customer\Manager\Group\Iface
{
	private $searchConfig = array(
		'customer.group.id' => array(
			'code' => 'customer.group.id',
			'internalcode' => 'ezro."id"',
			'label' => 'Customer group ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.group.code' => array(
			'code' => 'customer.group.code',
			'internalcode' => 'ezro."id"',
			'label' => 'Customer group code',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.group.label' => array(
			'code' => 'customer.group.label',
			'internalcode' => 'ezro."name"',
			'label' => 'Customer group label',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.group.ctime'=> array(
			'code' => 'customer.group.ctime',
			'internalcode' => '\'0\'',
			'label' => 'Customer group creation time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.group.mtime'=> array(
			'code' => 'customer.group.mtime',
			'internalcode' => '\'0\'',
			'label' => 'Customer group modification time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.group.editor'=> array(
			'code' => 'customer.group.editor',
			'internalcode' => '\'0\'',
			'label' => 'Customer group editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
	);


	/**
	 * Removes old entries from the database
	 *
	 * @param integer[] $siteids List of IDs for sites whose entries should be deleted
	 */
	public function cleanup( array $siteids )
	{
	}


	/**
	 * Removes multiple items specified by their IDs
	 *
	 * @param array $ids List of IDs
	 */
	public function deleteItems( array $ids )
	{
		throw new \Aimeos\MShop\Customer\Exception( sprintf( 'Deleting groups is not supported, please use the eZ Publish backend' ) );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array Returns a list of attribtes implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'mshop/customer/manager/group/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for customer group extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions
	 */
	public function getSubManager( $manager, $name = null )
	{
		return $this->getSubManagerBase( 'customer/group', $manager, ( $name === null ? 'Ezpublish' : $name ) );
	}


	/**
	 * Inserts a new or updates an existing customer group item
	 *
	 * @param \Aimeos\MShop\Customer\Item\Group\Iface $item Customer group item
	 * @param boolean $fetch True if the new ID should be returned in the item
	 */
	public function saveItem( \Aimeos\MShop\Common\Item\Iface $item, $fetch = true )
	{
		throw new \Aimeos\MShop\Customer\Exception( sprintf( 'Saving groups is not supported, please use the eZ Publish backend' ) );
	}


	/**
	 * Returns the item objects matched by the given search criteria.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param array $ref List of domain items that should be fetched too
	 * @param integer &$total Number of items that are available in total
	 * @return array List of items implementing \Aimeos\MShop\Customer\Item\Group\Iface
	 * @throws \Aimeos\MShop\Exception If retrieving items failed
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], &$total = null )
	{
		$map = [];
		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$required = array( 'customer.group' );
			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
			$cfgPathSearch = 'mshop/customer/manager/group/ezpublish/search';
			$cfgPathCount = 'mshop/customer/manager/group/ezpublish/count';

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $level );

			while( ( $row = $results->fetch() ) !== false ) {
				$map[$row['customer.group.id']] = $this->createItemBase( $row );
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		return $map;
	}
}
