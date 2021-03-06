<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 */


return array(
	'manager' => array(
		'address' => array(
			'ezpublish' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "ezuser_address"
						WHERE :cond AND siteid = ?
					',
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "ezuser_address" ( :names
							"parentid", "company", "vatid", "salutation", "title",
							"firstname", "lastname", "address1", "address2", "address3",
							"postal", "city", "state", "countryid", "langid", "telephone",
							"email", "telefax", "website", "longitude", "latitude",
							"pos", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					',
				),
				'update' => array(
					'ansi' => '
						UPDATE "ezuser_address"
						SET :names
							"parentid" = ?, "company" = ?, "vatid" = ?, "salutation" = ?,
							"title" = ?, "firstname" = ?, "lastname" = ?, "address1" = ?,
							"address2" = ?, "address3" = ?, "postal" = ?, "city" = ?,
							"state" = ?, "countryid" = ?, "langid" = ?, "telephone" = ?,
							"email" = ?, "telefax" = ?, "website" = ?, "longitude" = ?, "latitude" = ?,
							"pos" = ?, "mtime" = ?, "editor" = ?, "siteid" = ?
						WHERE "id" = ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT DISTINCT :columns
							ezpad."id" AS "customer.address.id", ezpad."parentid" AS "customer.address.parentid",
							ezpad."company" AS "customer.address.company", ezpad."vatid" AS "customer.address.vatid",
							ezpad."salutation" AS "customer.address.salutation", ezpad."title" AS "customer.address.title",
							ezpad."firstname" AS "customer.address.firstname", ezpad."lastname" AS "customer.address.lastname",
							ezpad."address1" AS "customer.address.address1", ezpad."address2" AS "customer.address.address2",
							ezpad."address3" AS "customer.address.address3", ezpad."postal" AS "customer.address.postal",
							ezpad."city" AS "customer.address.city", ezpad."state" AS "customer.address.state",
							ezpad."countryid" AS "customer.address.countryid", ezpad."langid" AS "customer.address.languageid",
							ezpad."telephone" AS "customer.address.telephone", ezpad."email" AS "customer.address.email",
							ezpad."telefax" AS "customer.address.telefax", ezpad."website" AS "customer.address.website",
							ezpad."longitude" AS "customer.address.longitude", ezpad."latitude" AS "customer.address.latitude",
							ezpad."pos" AS "customer.address.position", ezpad."mtime" AS "customer.address.mtime",
							ezpad."editor" AS "customer.address.editor", ezpad."ctime" AS "customer.address.ctime",
							ezpad."siteid" AS "customer.address.siteid"
						FROM "ezuser_address" AS ezpad
						:joins
						WHERE :cond
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT DISTINCT ezpad."id"
							FROM "ezuser_address" AS ezpad
							:joins
							WHERE :cond
							LIMIT 10000 OFFSET 0
						) AS list
					',
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT ezuser_address.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'lists' => array(
			'type' => array(
				'ezpublish' => array(
					'insert' => array(
						'ansi' => '
							INSERT INTO "ezuser_list_type" ( :names
								"code", "domain", "label", "pos", "status",
								"mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						',
					),
					'update' => array(
						'ansi' => '
							UPDATE "ezuser_list_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
								"status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						',
					),
					'delete' => array(
						'ansi' => '
							DELETE FROM "ezuser_list_type"
							WHERE :cond AND siteid = ?
						',
					),
					'search' => array(
						'ansi' => '
							SELECT DISTINCT :columns
								ezplity."id" AS "customer.lists.type.id", ezplity."siteid" AS "customer.lists.type.siteid",
								ezplity."code" AS "customer.lists.type.code", ezplity."domain" AS "customer.lists.type.domain",
								ezplity."label" AS "customer.lists.type.label", ezplity."status" AS "customer.lists.type.status",
								ezplity."mtime" AS "customer.lists.type.mtime", ezplity."editor" AS "customer.lists.type.editor",
								ezplity."ctime" AS "customer.lists.type.ctime", ezplity."pos" AS "customer.lists.type.position"
							FROM "ezuser_list_type" AS ezplity
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						',
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT DISTINCT ezplity."id"
								FROM "ezuser_list_type" AS ezplity
								:joins
								WHERE :cond
								LIMIT 10000 OFFSET 0
							) AS LIST
						',
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT ezuser_list_type.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
			),
			'ezpublish' => array(
				'aggregate' => array(
					'ansi' => '
						SELECT "key", COUNT(DISTINCT "id") AS "count"
						FROM (
							SELECT :key AS "key", ezpli."id" AS "id"
							FROM "ezuser_list" AS ezpli
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					',
				),
				'getposmax' => array(
					'ansi' => '
						SELECT MAX( "pos" ) AS pos
						FROM "ezuser_list"
						WHERE "siteid" = ?
							AND "parentid" = ?
							AND "type" = ?
							AND "domain" = ?
					',
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "ezuser_list" ( :names
							"parentid", "type", "domain", "refid", "start", "end",
							"config", "pos", "status", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					',
				),
				'update' => array(
					'ansi' => '
						UPDATE "ezuser_list"
						SET :names
							"parentid"=?, "key" = ?, "type" = ?, "domain" = ?, "refid" = ?, "start" = ?,
							"end" = ?, "config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					',
				),
				'updatepos' => array(
					'ansi' => '
						UPDATE "ezuser_list"
							SET "pos" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					',
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "ezuser_list"
						WHERE :cond AND siteid = ?
					',
				),
				'move' => array(
					'ansi' => '
						UPDATE "ezuser_list"
							SET "pos" = "pos" + ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ?
							AND "parentid" = ?
							AND "type" = ?
							AND "domain" = ?
							AND "pos" >= ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							ezpli."id" AS "customer.lists.id", ezpli."siteid" AS "customer.lists.siteid",
							ezpli."parentid" AS "customer.lists.parentid", ezpli."type" AS "customer.lists.type",
							ezpli."domain" AS "customer.lists.domain", ezpli."refid" AS "customer.lists.refid",
							ezpli."start" AS "customer.lists.datestart", ezpli."end" AS "customer.lists.dateend",
							ezpli."config" AS "customer.lists.config", ezpli."pos" AS "customer.lists.position",
							ezpli."status" AS "customer.lists.status", ezpli."mtime" AS "customer.lists.mtime",
							ezpli."editor" AS "customer.lists.editor", ezpli."ctime" AS "customer.lists.ctime"
						FROM "ezuser_list" AS ezpli
						:joins
						WHERE :cond
						GROUP BY :columns ezpli."id", ezpli."parentid", ezpli."siteid", ezpli."type",
							ezpli."domain", ezpli."refid", ezpli."start", ezpli."end",
							ezpli."config", ezpli."pos", ezpli."status", ezpli."mtime",
							ezpli."editor", ezpli."ctime"
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT DISTINCT ezpli."id"
							FROM "ezuser_list" AS ezpli
							:joins
							WHERE :cond
							LIMIT 10000 OFFSET 0
						) AS list
					',
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT ezuser_list.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'property' => array(
			'type' => array(
				'ezpublish' => array(
					'delete' => array(
						'ansi' => '
							DELETE FROM "ezuser_property_type"
							WHERE :cond AND siteid = ?
						'
					),
					'insert' => array(
						'ansi' => '
							INSERT INTO "ezuser_property_type" ( :names
								"code", "domain", "label", "pos", "status",
								"mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						'
					),
					'update' => array(
						'ansi' => '
							UPDATE "ezuser_property_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
								"status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						'
					),
					'search' => array(
						'ansi' => '
							SELECT DISTINCT :columns
								ezpprty."id" AS "customer.property.type.id", ezpprty."siteid" AS "customer.property.type.siteid",
								ezpprty."code" AS "customer.property.type.code", ezpprty."domain" AS "customer.property.type.domain",
								ezpprty."label" AS "customer.property.type.label", ezpprty."status" AS "customer.property.type.status",
								ezpprty."mtime" AS "customer.property.type.mtime", ezpprty."editor" AS "customer.property.type.editor",
								ezpprty."ctime" AS "customer.property.type.ctime", ezpprty."pos" AS "customer.property.type.position"
							FROM "ezuser_property_type" ezpprty
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						'
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT DISTINCT ezpprty."id"
								FROM "ezuser_property_type" ezpprty
								:joins
								WHERE :cond
								LIMIT 10000 OFFSET 0
							) AS list
						'
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT ezuser_property_type_seq.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
			),
			'ezpublish' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "ezuser_property"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "ezuser_property" ( :names
							"parentid", "type", "langid", "value",
							"mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "ezuser_property"
						SET :names
							"parentid" = ?, "type" = ?, "langid" = ?,
							"value" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT DISTINCT :columns
							ezppr."id" AS "customer.property.id", ezppr."parentid" AS "customer.property.parentid",
							ezppr."siteid" AS "customer.property.siteid", ezppr."type" AS "customer.property.type",
							ezppr."langid" AS "customer.property.languageid", ezppr."value" AS "customer.property.value",
							ezppr."mtime" AS "customer.property.mtime", ezppr."editor" AS "customer.property.editor",
							ezppr."ctime" AS "customer.property.ctime"
						FROM "ezuser_property" AS ezppr
						:joins
						WHERE :cond
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT DISTINCT ezppr."id"
							FROM "ezuser_property" AS ezppr
							:joins
							WHERE :cond
							LIMIT 10000 OFFSET 0
						) AS list
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT ezuser_property_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'ezpublish' => array(
			'delete' => array(
				'ansi' => '
					DELETE FROM "ezuser"
					WHERE :cond
				',
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "ezuser" ( :names
						"siteid", "username_canonical", "username", "company", "vatid", "salutation", "title",
						"firstname", "lastname", "address1", "address2", "address3",
						"postal", "city", "state", "countryid", "langid", "telephone",
						"email_canonical", "email", "telefax", "website", "longitude", "latitude",
						"birthday", "enabled", "vdate", "password", "mtime", "editor", "roles", "salt",
						"ctime"
					) VALUES ( :values
						?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
					)
				',
			),
			'update' => array(
				'ansi' => '
					UPDATE "ezuser"
					SET :names
						"siteid" = ?, "username_canonical" = ?, "username" = ?, "company" = ?, "vatid" = ?,
						"salutation" = ?, "title" = ?, "firstname" = ?, "lastname" = ?,
						"address1" = ?, "address2" = ?, "address3" = ?, "postal" = ?,
						"city" = ?, "state" = ?, "countryid" = ?, "langid" = ?,
						"telephone" = ?, "email_canonical" = ?, "email" = ?, "telefax" = ?,
						"website" = ?, "longitude" = ?, "latitude" = ?, "birthday" = ?, "enabled" = ?,
						"vdate" = ?, "password" = ?, "mtime" = ?, "editor" = ?, "roles" = ?, "salt" = ?
					WHERE "id" = ?
				',
			),
			'search' => array(
				'ansi' => '
					SELECT DISTINCT :columns
						ezp."id" AS "customer.id", ezp."siteid" AS "customer.siteid",
						ezp."username_canonical" as "customer.code", ezp."username" as "customer.label",
						ezp."company" AS "customer.company", ezp."vatid" AS "customer.vatid",
						ezp."salutation" AS "customer.salutation", ezp."title" AS "customer.title",
						ezp."firstname" AS "customer.firstname", ezp."lastname" AS "customer.lastname",
						ezp."address1" AS "customer.address1", ezp."address2" AS "customer.address2",
						ezp."address3" AS "customer.address3", ezp."postal" AS "customer.postal",
						ezp."city" AS "customer.city", ezp."state" AS "customer.state",
						ezp."countryid" AS "customer.countryid", ezp."langid" AS "customer.languageid",
						ezp."telephone" AS "customer.telephone", ezp."email_canonical" AS "customer.email",
						ezp."telefax" AS "customer.telefax", ezp."website" AS "customer.website",
						ezp."longitude" AS "customer.longitude", ezp."latitude" AS "customer.latitude",
						ezp."birthday" AS "customer.birthday", ezp."enabled" AS "customer.status",
						ezp."vdate" AS "customer.vdate", ezp."password" AS "customer.password",
						ezp."ctime" AS "customer.ctime", ezp."mtime" AS "customer.mtime",
						ezp."editor" AS "customer.editor", ezp."roles", ezp."salt"
					FROM "ezuser" AS ezp
					:joins
					WHERE :cond
					/*-orderby*/ ORDER BY :order /*orderby-*/
					LIMIT :size OFFSET :start
				',
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT DISTINCT ezp."id"
						FROM "ezuser" AS ezp
						:joins
						WHERE :cond
						LIMIT 10000 OFFSET 0
					) AS list
				',
			),
			'newid' => array(
				'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
				'mysql' => 'SELECT LAST_INSERT_ID()',
				'oracle' => 'SELECT ezuser.CURRVAL FROM DUAL',
				'pgsql' => 'SELECT lastval()',
				'sqlite' => 'SELECT last_insert_rowid()',
				'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
				'sqlanywhere' => 'SELECT @@IDENTITY',
			),
		),
	),
);
