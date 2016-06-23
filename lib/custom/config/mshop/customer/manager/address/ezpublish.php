<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */

return array(
	'delete' => array(
		'ansi' => '
			DELETE FROM "ezuser_address"
			WHERE :cond
		',
	),
	'insert' => array(
		'ansi' => '
			INSERT INTO "ezuser_address" (
				"siteid", "parentid", "company", "vatid", "salutation", "title",
				"firstname", "lastname", "address1", "address2", "address3",
				"postal", "city", "state", "countryid", "langid", "telephone",
				"email", "telefax", "website", "flag", "pos", "mtime",
				"editor", "ctime"
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
			)
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "ezuser_address"
			SET "siteid" = ?, "parentid" = ?, "company" = ?, "vatid" = ?, "salutation" = ?,
				"title" = ?, "firstname" = ?, "lastname" = ?, "address1" = ?,
				"address2" = ?, "address3" = ?, "postal" = ?, "city" = ?,
				"state" = ?, "countryid" = ?, "langid" = ?, "telephone" = ?,
				"email" = ?, "telefax" = ?, "website" = ?, "flag" = ?,
				"pos" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT DISTINCT ezuad."id" AS "customer.address.id", ezuad."parentid" AS "customer.address.parentid",
				ezuad."company" AS "customer.address.company", ezuad."vatid" AS "customer.address.vatid",
				ezuad."salutation" AS "customer.address.salutation", ezuad."title" AS "customer.address.title",
				ezuad."firstname" AS "customer.address.firstname", ezuad."lastname" AS "customer.address.lastname",
				ezuad."address1" AS "customer.address.address1", ezuad."address2" AS "customer.address.address2",
				ezuad."address3" AS "customer.address.address3", ezuad."postal" AS "customer.address.postal",
				ezuad."city" AS "customer.address.city", ezuad."state" AS "customer.address.state",
				ezuad."countryid" AS "customer.address.countryid", ezuad."langid" AS "customer.address.languageid",
				ezuad."telephone" AS "customer.address.telephone", ezuad."email" AS "customer.address.email",
				ezuad."telefax" AS "customer.address.telefax", ezuad."website" AS "customer.address.website",
				ezuad."flag" AS "customer.address.flag", ezuad."pos" AS "customer.address.position",
				ezuad."mtime" AS "customer.address.mtime", ezuad."editor" AS "customer.address.editor",
				ezuad."ctime" AS "customer.address.ctime"
			FROM "ezuser_address" AS ezuad
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
				SELECT DISTINCT ezuad."id"
				FROM "ezuser_address" AS ezuad
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
);
