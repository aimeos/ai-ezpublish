<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2017
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Address;


/**
 * ezPublish implementation of the customer address class.
 *
 * @package MShop
 * @subpackage Customer
 */
class Ezpublish
	extends \Aimeos\MShop\Customer\Manager\Address\Standard
	implements \Aimeos\MShop\Customer\Manager\Address\Iface
{
	private $searchConfig = array(
		'customer.address.id' => array(
			'label' => 'Customer address ID',
			'code' => 'customer.address.id',
			'internalcode' => 'ezuad."id"',
			'internaldeps' => array( 'LEFT JOIN "ezuser_address" AS ezuad ON ( ezu."contentobject_id" = ezuad."parentid" )' ),
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		// site ID is not available
		'customer.address.refid' => array(
			'label' => 'Customer address parent ID',
			'code' => 'customer.address.parentid',
			'internalcode' => 'ezuad."parentid"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.address.company'=> array(
			'label' => 'Customer address company',
			'code' => 'customer.address.company',
			'internalcode' => 'ezuad."company"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.vatid'=> array(
			'label' => 'Customer address VAT ID',
			'code' => 'customer.address.vatid',
			'internalcode' => 'ezuad."vatid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.salutation' => array(
			'label' => 'Customer address salutation',
			'code' => 'customer.address.salutation',
			'internalcode' => 'ezuad."salutation"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.title' => array(
			'label' => 'Customer address title',
			'code' => 'customer.address.title',
			'internalcode' => 'ezuad."title"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.firstname' => array(
			'label' => 'Customer address firstname',
			'code' => 'customer.address.firstname',
			'internalcode' => 'ezuad."firstname"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.lastname' => array(
			'label' => 'Customer address lastname',
			'code' => 'customer.address.lastname',
			'internalcode' => 'ezuad."lastname"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.address1' => array(
			'label' => 'Customer address address part one',
			'code' => 'customer.address.address1',
			'internalcode' => 'ezuad."address1"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.address2' => array(
			'label' => 'Customer address address part two',
			'code' => 'customer.address.address2',
			'internalcode' => 'ezuad."address2"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.address3' => array(
			'label' => 'Customer address address part three',
			'code' => 'customer.address.address3',
			'internalcode' => 'ezuad."address3"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.postal' => array(
			'label' => 'Customer address postal',
			'code' => 'customer.address.postal',
			'internalcode' => 'ezuad."postal"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.city' => array(
			'label' => 'Customer address city',
			'code' => 'customer.address.city',
			'internalcode' => 'ezuad."city"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.state' => array(
			'label' => 'Customer address state',
			'code' => 'customer.address.state',
			'internalcode' => 'ezuad."state"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.languageid' => array(
			'label' => 'Customer address language',
			'code' => 'customer.address.languageid',
			'internalcode' => 'ezuad."langid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.countryid' => array(
			'label' => 'Customer address country',
			'code' => 'customer.address.countryid',
			'internalcode' => 'ezuad."countryid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.telephone' => array(
			'label' => 'Customer address telephone',
			'code' => 'customer.address.telephone',
			'internalcode' => 'ezuad."telephone"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.email' => array(
			'label' => 'Customer address email',
			'code' => 'customer.address.email',
			'internalcode' => 'ezuad."email"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.telefax' => array(
			'label' => 'Customer address telefax',
			'code' => 'customer.address.telefax',
			'internalcode' => 'ezuad."telefax"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.website' => array(
			'label' => 'Customer address website',
			'code' => 'customer.address.website',
			'internalcode' => 'ezuad."website"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.flag' => array(
			'label' => 'Customer address flag',
			'code' => 'customer.address.flag',
			'internalcode' => 'ezuad."flag"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.address.position' => array(
			'label' => 'Customer address position',
			'code' => 'customer.address.position',
			'internalcode' => 'ezuad."pos"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.address.ctime'=> array(
			'label'=>'Customer address create date/time',
			'code'=>'customer.address.ctime',
			'internalcode'=>'ezuad."ctime"',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.mtime'=> array(
			'label'=>'Customer address modification date/time',
			'code'=>'customer.address.mtime',
			'internalcode'=>'ezuad."mtime"',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.editor'=> array(
			'label'=>'Customer address editor',
			'code'=>'customer.address.editor',
			'internalcode'=>'ezuad."editor"',
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
		$path = 'mshop/customer/manager/address/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, [] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->cleanup( $siteids );
		}

		$this->cleanupBase( $siteids, 'mshop/customer/manager/lists/ezpublish/delete' );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array Returns a list of attribtes implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'mshop/customer/manager/address/submanagers';

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
		return $this->getSubManagerBase( 'customer', 'address/' . $manager, ( $name === null ? 'Ezpublish' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path (mshop/customer/manager/address/ezpublish/)
	 */
	protected function getConfigPath()
	{
		return 'mshop/customer/manager/address/ezpublish/';
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
