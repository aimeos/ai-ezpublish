<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager;


/**
 * Customer class implementation for ezPublish
 *
 * @package MShop
 * @subpackage Customer
 */
class Ezpublish
	extends \Aimeos\MShop\Customer\Manager\Standard
{
	private $searchConfig = array(
		'customer.id' => array(
			'label' => 'Customer ID',
			'code' => 'customer.id',
			'internalcode' => 'ezu."contentobject_id"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT
		),
		// customer.siteid is not available
		'customer.label' => array(
			'label' => 'Customer label',
			'code' => 'customer.label',
			'internalcode' => 'ezu."login"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR
		),
		'customer.code' => array(
			'label' => 'Customer username',
			'code' => 'customer.code',
			'internalcode' => 'ezu."login_normalized"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR
		),
		'customer.salutation' => array(
			'label' => 'Customer salutation',
			'code' => 'customer.salutation',
			'internalcode' => 'ezu."salutation"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.company'=> array(
			'label' => 'Customer company',
			'code' => 'customer.company',
			'internalcode' => 'ezu."company"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.vatid'=> array(
			'label' => 'Customer VAT ID',
			'code' => 'customer.vatid',
			'internalcode' => 'ezu."vatid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.title' => array(
			'label' => 'Customer title',
			'code' => 'customer.title',
			'internalcode' => 'ezu."title"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.firstname' => array(
			'label' => 'Customer firstname',
			'code' => 'customer.firstname',
			'internalcode' => 'ezu."firstname"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lastname' => array(
			'label' => 'Customer lastname',
			'code' => 'customer.lastname',
			'internalcode' => 'ezu."lastname"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address1' => array(
			'label' => 'Customer address part one',
			'code' => 'customer.address1',
			'internalcode' => 'ezu."address1"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address2' => array(
			'label' => 'Customer address part two',
			'code' => 'customer.address2',
			'internalcode' => 'ezu."address2"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address3' => array(
			'label' => 'Customer address part three',
			'code' => 'customer.address3',
			'internalcode' => 'ezu."address3"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.postal' => array(
			'label' => 'Customer postal',
			'code' => 'customer.postal',
			'internalcode' => 'ezu."postal"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.city' => array(
			'label' => 'Customer city',
			'code' => 'customer.city',
			'internalcode' => 'ezu."city"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.state' => array(
			'label' => 'Customer state',
			'code' => 'customer.state',
			'internalcode' => 'ezu."state"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.languageid' => array(
			'label' => 'Customer language',
			'code' => 'customer.languageid',
			'internalcode' => 'ezu."langid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.countryid' => array(
			'label' => 'Customer country',
			'code' => 'customer.countryid',
			'internalcode' => 'ezu."countryid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.telephone' => array(
			'label' => 'Customer telephone',
			'code' => 'customer.telephone',
			'internalcode' => 'ezu."telephone"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.email' => array(
			'label' => 'Customer email',
			'code' => 'customer.email',
			'internalcode' => 'ezu."email"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.telefax' => array(
			'label' => 'Customer telefax',
			'code' => 'customer.telefax',
			'internalcode' => 'ezu."telefax"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.website' => array(
			'label' => 'Customer website',
			'code' => 'customer.website',
			'internalcode' => 'ezu."website"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.birthday' => array(
			'label' => 'Customer birthday',
			'code' => 'customer.birthday',
			'internalcode' => 'ezu."birthday"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.password'=> array(
			'label' => 'Customer password',
			'code' => 'customer.password',
			'internalcode' => 'ezu."password_hash"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.status'=> array(
			'label' => 'Customer status',
			'code' => 'customer.status',
			'internalcode' => 'ezs."is_enabled"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT
		),
		'customer.dateverified'=> array(
			'label' => 'Customer verification date',
			'code' => 'customer.dateverified',
			'internalcode' => 'ezu."vdate"',
			'type' => 'date',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.ctime'=> array(
			'label' => 'Customer creation time',
			'code' => 'customer.ctime',
			'internalcode' => 'ezu."ctime"',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.mtime'=> array(
			'label' => 'Customer modification time',
			'code' => 'customer.mtime',
			'internalcode' => 'ezu."mtime"',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.editor'=> array(
			'label'=>'Customer editor',
			'code'=>'customer.editor',
			'internalcode' => 'ezu."editor"',
			'type'=> 'string',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer:has' => array(
			'code' => 'customer:has()',
			'internalcode' => '(
				SELECT ezuli_has."id" FROM ezuser_list AS ezuli_has
				WHERE ezu."id" = ezuli_has."parentid" AND :site
					AND ezuli_has."domain" = $1 AND ezuli_has."type" = $2 AND ezuli_has."refid" = $3
			)',
			'label' => 'Customer has list item, parameter(<domain>,<list type>,<reference ID>)',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
		'customer:prop' => array(
			'code' => 'customer:prop()',
			'internalcode' => '(
				SELECT ezupr_prop."id" FROM ezuser_property AS ezupr_prop
				WHERE ezu."id" = ezupr_prop."parentid" AND :site
					AND ezupr_prop."type" = $1 AND ezupr_prop."value" = $3
					AND ( ezupr_prop."langid" = $2 OR ezupr_prop."langid" IS NULL )
			)',
			'label' => 'Customer has property item, parameter(<property type>,<language code>,<property value>)',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
	);


	/**
	 * Initializes the object.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$locale = $context->getLocale();
		$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
		$level = $context->getConfig()->get( 'mshop/customer/manager/sitemode', $level );

		$siteIds = [$locale->getSiteId()];

		if( $level & \Aimeos\MShop\Locale\Manager\Base::SITE_PATH ) {
			$siteIds = array_merge( $siteIds, $locale->getSitePath() );
		}

		if( $level & \Aimeos\MShop\Locale\Manager\Base::SITE_SUBTREE ) {
			$siteIds = array_merge( $siteIds, $locale->getSiteSubTree() );
		}

		$this->replaceSiteMarker( $this->searchConfig['customer:has'], 'ezuli_has."siteid"', $siteIds, ':site' );
		$this->replaceSiteMarker( $this->searchConfig['customer:prop'], 'ezupr_prop."siteid"', $siteIds, ':site' );
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param array $siteids List of IDs for sites whose entries should be deleted
	 */
	public function cleanup( array $siteids )
	{
		$path = 'mshop/customer/manager/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, ['address', 'group', 'lists', 'property'] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->cleanup( $siteids );
		}
	}


	/**
	 * Removes multiple items specified by ids in the array.
	 *
	 * @param array $ids List of IDs
	 */
	public function deleteItems( array $ids )
	{
		$service = $this->getContext()->getEzUserService();

		foreach( $ids as $id ) {
			$service->deleteUser( $service->loadUser( $id ) );
		}
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'mshop/customer/manager/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, ['address', 'group', 'lists', 'property'], $withsub );
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
		return $this->getSubManagerBase( 'customer', $manager, ( $name === null ? 'Ezpublish' : $name ) );
	}


	/**
	 * Saves a customer item object.
	 *
	 * @param \Aimeos\MShop\Customer\Item\Iface $item Customer item object
	 * @param boolean $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Common\Item\Iface $item Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Common\Item\Iface $item, $fetch = true )
	{
		self::checkClass( '\\Aimeos\\MShop\\Customer\\Item\\Iface', $item );

		if( !$item->isModified() )
		{
			$item = $this->savePropertyItems( $item, 'customer' );
			$item = $this->saveAddressItems( $item, 'customer' );
			return $this->saveListItems( $item, 'customer' );
		}

		$context = $this->getContext();

		$class = '\Aimeos\MShop\Context\Item\Ezpublish';
		if( !is_a( $context, $class ) ) {
			throw new \Aimeos\MShop\Customer\Exception( sprintf( 'Object is not of required type "%1$s"', $class ) );
		}

		$service = $context->getEzUserService();
		$email = $item->getPaymentAddress()->getEmail();

		if( $item->getId() !== null )
		{
			$struct = $service->newUserUpdateStruct();
			$struct->password = $item->getPassword();
			$struct->enabled = $item->getStatus();
			$struct->email = $email;

			$user = $service->loadUser( $item->getId() );
			$service->updateUser( $user, $struct );
		}
		else
		{
			$struct = $service->newUserCreateStruct( $item->getCode(), $email, $item->getPassword(), 'eng-GB' );
			$struct->enabled = $item->getStatus();

			$user = $service->createUser( $struct, [] );
			$item->setId( $user->getUserId() );
		}

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$date = date( 'Y-m-d H:i:s' );
			$ctime = ( $item->getTimeCreated() ? $item->getTimeCreated() : $date );
			$billingAddress = $item->getPaymentAddress();

			$path = 'mshop/customer/manager/ezpublish/update';
			$stmt = $this->getCachedStatement( $conn, $path );

			$stmt->bind( 1, $billingAddress->getCompany() );
			$stmt->bind( 2, $billingAddress->getVatID() );
			$stmt->bind( 3, $billingAddress->getSalutation() );
			$stmt->bind( 4, $billingAddress->getTitle() );
			$stmt->bind( 5, $billingAddress->getFirstname() );
			$stmt->bind( 6, $billingAddress->getLastname() );
			$stmt->bind( 7, $billingAddress->getAddress1() );
			$stmt->bind( 8, $billingAddress->getAddress2() );
			$stmt->bind( 9, $billingAddress->getAddress3() );
			$stmt->bind( 10, $billingAddress->getPostal() );
			$stmt->bind( 11, $billingAddress->getCity() );
			$stmt->bind( 12, $billingAddress->getState() );
			$stmt->bind( 13, $billingAddress->getCountryId() );
			$stmt->bind( 14, $billingAddress->getLanguageId() );
			$stmt->bind( 15, $billingAddress->getTelephone() );
			$stmt->bind( 16, $billingAddress->getTelefax() );
			$stmt->bind( 17, $billingAddress->getWebsite() );
			$stmt->bind( 18, $item->getBirthday() );
			$stmt->bind( 19, $item->getDateVerified() );
			$stmt->bind( 20, $date ); // Modification time
			$stmt->bind( 21, $context->getEditor() );
			$stmt->bind( 22, $ctime ); // Creation time
			$stmt->bind( 23, $item->getId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );

			$stmt->execute()->finish();

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		$item = $this->savePropertyItems( $item, 'customer' );
		$item = $this->saveAddressItems( $item, 'customer' );
		return $this->saveListItems( $item, 'customer' );
	}


	/**
	 * Returns the item objects matched by the given search criteria.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param integer &$total Number of items that are available in total
	 * @return array List of items implementing \Aimeos\MShop\Customer\Item\Iface
	 * @throws \Aimeos\MShop\Customer\Exception If creating items failed
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], &$total = null )
	{
		$dbm = $this->getContext()->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );
		$map = [];

		try
		{
			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
			$cfgPathSearch = 'mshop/customer/manager/ezpublish/search';
			$cfgPathCount = 'mshop/customer/manager/ezpublish/count';
			$required = array( 'customer' );

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $level );

			while( ( $row = $results->fetch() ) !== false )
			{
				$map[ $row['customer.id'] ] = $row;
				$map[ $row['customer.id'] ]['groups'] = [];
			}


			$path = 'mshop/customer/manager/ezpublish/groups';
			$stmt = $conn->create( $this->getGroupSql( array_keys( $map ), $path ) );
			$results = $stmt->execute();

			while( ( $row = $results->fetch() ) !== false ) {
				$map[ $row['contentobject_id'] ]['groups'][] = $row['role_id'];
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname  );
			throw $e;
		}

		return $this->buildItems( $map, $ref, 'customer' );
	}


	/**
	 * Creates a new customer item.
	 *
	 * @param array $values List of attributes for customer item
	 * @param \Aimeos\MShop\Common\Lists\Item\Iface[] $listItems List of list items
	 * @param \Aimeos\MShop\Common\Item\Iface[] $refItems List of referenced items
	 * @param \Aimeos\MShop\Common\Item\Address\Iface[] $addrItems List of referenced address items
	 * @param \Aimeos\MShop\Common\Item\Property\Iface[] $propItems List of property items
	 * @return \Aimeos\MShop\Customer\Item\Iface New customer item
	 */
	protected function createItemBase( array $values = [], array $listItems = [], array $refItems = [],
		array $addrItems = [], array $propItems = [] )
	{
		$address = new \Aimeos\MShop\Common\Item\Address\Simple( 'customer.', $values );

		return new \Aimeos\MShop\Customer\Item\Ezpublish(
			$address, $values, $listItems, $refItems, $addrItems, $propItems
		);
	}


	/**
	 * Returns the SQL statement for retrieving the customer group IDs
	 *
	 * @param array $ids List of customer IDs
	 * @param string $cfgpath Configuration path to the SQL statement
	 * @return string SQL statement ready for execution
	 */
	protected function getGroupSql( array $ids, $cfgpath )
	{
		if( empty( $ids ) ) { return '1=1'; }

		$search = $this->getObject()->createSearch();
		$search->setConditions( $search->compare( '==', 'id', $ids ) );

		$types = array( 'id' => \Aimeos\MW\DB\Statement\Base::PARAM_INT );
		$translations = array( 'id' => '"contentobject_id"' );

		$cond = $search->getConditionSource( $types, $translations );

		return str_replace( ':cond', $cond, $this->getSqlConfig( $cfgpath ) );
	}
}
