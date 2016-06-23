<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds customer list test data.
 */
class CustomerListAddEzpublishTestData
	extends \Aimeos\MW\Setup\Task\CustomerListAddTestData
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies()
	{
		return array( 'TablesCreateEzpublish', 'CustomerAddEzpublishTestData', 'LocaleAddTestData', 'TextAddTestData' );
	}


	/**
	 * Adds attribute test data.
	 */
	public function migrate()
	{
		$iface = '\\Aimeos\\MShop\\Context\\Item\\Iface';
		if( !( $this->additional instanceof $iface ) ) {
			throw new \Aimeos\MW\Setup\Exception( sprintf( 'Additionally provided object is not of type "%1$s"', $iface ) );
		}

		$this->msg( 'Adding customer-list ezPublish test data', 0 );
		$this->additional->setEditor( 'ai-ezpublish:unittest' );

		$ds = DIRECTORY_SEPARATOR;
		$path = dirname( __FILE__ ) . $ds . 'data' . $ds . 'customer-list.php';

		if( ( $testdata = include( $path ) ) === false ){
			throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for customer list domain', $path ) );
		}

		$refKeys = array();
		foreach( $testdata['customer/lists'] as $dataset ) {
			$refKeys[ $dataset['domain'] ][] = $dataset['refid'];
		}

		$refIds = array();
		$refIds['text'] = $this->getTextData( $refKeys['text'] );
		$this->addCustomerListData( $testdata, $refIds, 'Ezpublish' );

		$this->status( 'done' );
	}
}