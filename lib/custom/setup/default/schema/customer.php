<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2017
 */


return array(
	'table' => array(
		'ezuser' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'ezuser' );

			$table->addColumn( 'contentobject_id', 'integer', [] );
			$table->addColumn( 'email', 'string', array( 'length' => 150 ) );
			$table->addColumn( 'login', 'string', array( 'length' => 150 ) );
			$table->addColumn( 'login_normalized', 'string', array( 'length' => 150 ) );
			$table->addColumn( 'password_hash', 'string', array( 'length' => 50 ) );
			$table->addColumn( 'password_hash_type', 'integer', array( 'default' => 1 ) );

			$table->setPrimaryKey( array( 'contentobject_id' ) );
			$table->addUniqueIndex( array( 'login_normalized' ), 'ezuser_login' );

			return $schema;
		},

		'ezuser_address' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'ezuser_address' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'integer', [] );
			$table->addColumn( 'parentid', 'integer', [] );
			$table->addColumn( 'company', 'string', array( 'length' => 100 ) );
			$table->addColumn( 'vatid', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'salutation', 'string', array( 'length' => 8 ) );
			$table->addColumn( 'title', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'firstname', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'lastname', 'string', array( 'length' => 64 ) );
			$table->addColumn( 'address1', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'address2', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'address3', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'postal', 'string', array( 'length' => 16 ) );
			$table->addColumn( 'city', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'state', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'langid', 'string', array( 'length' => 5, 'notnull' => false ) );
			$table->addColumn( 'countryid', 'string', array( 'length' => 2, 'notnull' => false, 'fixed' => true ) );
			$table->addColumn( 'telephone', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'email', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'telefax', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'website', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'flag', 'integer', [] );
			$table->addColumn( 'pos', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array('length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_ezpad_id' );
			$table->addIndex( array( 'lastname', 'firstname' ), 'idx_ezpad_ln_fn' );
			$table->addIndex( array( 'address1', 'address2' ), 'idx_ezpad_ad1_ad2' );
			$table->addIndex( array( 'postal', 'city' ), 'idx_ezpad_post_ci' );
			$table->addIndex( array( 'parentid' ), 'idx_ezpad_pid' );
			$table->addIndex( array( 'city' ), 'idx_ezpad_city' );

			$table->addForeignKeyConstraint( 'ezuser', array( 'parentid' ), array( 'contentobject_id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_ezpad_pid' );

			return $schema;
		},

		'ezuser_list_type' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'ezuser_list_type' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'integer', [] );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'code', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'label', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'pos', 'integer', ['default' => 0] );
			$table->addColumn( 'status', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_ezplity_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'code' ), 'unq_ezplity_sid_dom_code' );
			$table->addIndex( array( 'siteid', 'status' ), 'idx_ezplity_sid_status' );
			$table->addIndex( array( 'siteid', 'label' ), 'idx_ezplity_sid_label' );
			$table->addIndex( array( 'siteid', 'code' ), 'idx_ezplity_sid_code' );

			return $schema;
		},

		'ezuser_list' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'ezuser_list' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'parentid', 'integer', [] );
			$table->addColumn( 'siteid', 'integer', [] );
			$table->addColumn( 'typeid', 'integer', [] );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'refid', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'start', 'datetime', array( 'notnull' => false ) );
			$table->addColumn( 'end', 'datetime', array( 'notnull' => false ) );
			$table->addColumn( 'config', 'text', array( 'length' => 0xffff ) );
			$table->addColumn( 'pos', 'integer', [] );
			$table->addColumn( 'status', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_ezpli_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'refid', 'typeid', 'parentid' ), 'unq_ezpli_sid_dm_rid_tid_pid' );
			$table->addIndex( array( 'siteid', 'status', 'start', 'end' ), 'idx_ezpli_sid_stat_start_end' );
			$table->addIndex( array( 'parentid', 'siteid', 'refid', 'domain', 'typeid' ), 'idx_ezpli_pid_sid_rid_dom_tid' );
			$table->addIndex( array( 'parentid', 'siteid', 'start' ), 'idx_ezpli_pid_sid_start' );
			$table->addIndex( array( 'parentid', 'siteid', 'end' ), 'idx_ezpli_pid_sid_end' );
			$table->addIndex( array( 'parentid', 'siteid', 'pos' ), 'idx_ezpli_pid_sid_pos' );

			$table->addForeignKeyConstraint( 'ezuser', array( 'parentid' ), array( 'contentobject_id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_ezpli_pid' );

			$table->addForeignKeyConstraint( 'ezuser_list_type', array( 'typeid' ), array( 'id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_ezpli_typeid' );

			return $schema;
		},

		'ezuser_property_type' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'ezuser_property_type' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'integer', [] );
			$table->addColumn( 'domain', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'code', 'string', array( 'length' => 32 ) );
			$table->addColumn( 'label', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'pos', 'integer', ['default' => 0] );
			$table->addColumn( 'status', 'smallint', [] );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_ezpprty_id' );
			$table->addUniqueIndex( array( 'siteid', 'domain', 'code' ), 'unq_ezpprty_sid_dom_code' );
			$table->addIndex( array( 'siteid', 'status', 'pos' ), 'idx_ezpprty_sid_status_pos' );
			$table->addIndex( array( 'siteid', 'label' ), 'idx_ezpprty_sid_label' );
			$table->addIndex( array( 'siteid', 'code' ), 'idx_ezpprty_sid_code' );

			return $schema;
		},

		'ezuser_property' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

			$table = $schema->createTable( 'ezuser_property' );

			$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
			$table->addColumn( 'siteid', 'integer', [] );
			$table->addColumn( 'parentid', 'integer', [] );
			$table->addColumn( 'typeid', 'integer', [] );
			$table->addColumn( 'langid', 'string', array( 'length' => 5, 'notnull' => false ) );
			$table->addColumn( 'value', 'string', array( 'length' => 255 ) );
			$table->addColumn( 'mtime', 'datetime', [] );
			$table->addColumn( 'ctime', 'datetime', [] );
			$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

			$table->setPrimaryKey( array( 'id' ), 'pk_ezppr_id' );
			$table->addUniqueIndex( array( 'parentid', 'siteid', 'typeid', 'langid', 'value' ), 'unq_ezppr_sid_tid_lid_value' );
			$table->addIndex( array( 'siteid', 'langid' ), 'idx_ezppr_sid_langid' );
			$table->addIndex( array( 'siteid', 'value' ), 'idx_ezppr_sid_value' );
			$table->addIndex( array( 'typeid' ), 'fk_ezppr_typeid' );
			$table->addIndex( array( 'parentid' ), 'fk_ezppr_pid' );

			$table->addForeignKeyConstraint( 'ezuser', array( 'parentid' ), array( 'contentobject_id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_ezppr_pid' );

			$table->addForeignKeyConstraint( 'ezuser_property_type', array( 'typeid' ), array( 'id' ),
				array( 'onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE' ), 'fk_ezppr_typeid' );

			return $schema;
		},
	),
);
