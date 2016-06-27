<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */

return array(
	'update' => array(
		'ansi' => '
			UPDATE "ezuser"
			SET "company" = ?, "vatid" = ?, "salutation" = ?, "title" = ?,
				"firstname" = ?, "lastname" = ?, "address1" = ?, "address2" = ?, "address3" = ?,
				"postal" = ?, "city" = ?, "state" = ?, "countryid" = ?, "langid" = ?,
				"telephone" = ?, "telefax" = ?, "website" = ?, "birthday" = ?, "vdate" = ?,
				"mtime" = ?, "editor" = ?, "ctime" = ?
			WHERE "contentobject_id" = ?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT DISTINCT ezu."contentobject_id" AS "customer.id",
				ezu."login_normalized" as "customer.code", ezu."login" as "customer.label",
				ezu."company" AS "customer.company", ezu."vatid" AS "customer.vatid",
				ezu."salutation" AS "customer.salutation", ezu."title" AS "customer.title",
				ezu."firstname" AS "customer.firstname", ezu."lastname" AS "customer.lastname",
				ezu."address1" AS "customer.address1", ezu."address2" AS "customer.address2",
				ezu."address3" AS "customer.address3", ezu."postal" AS "customer.postal",
				ezu."city" AS "customer.city", ezu."state" AS "customer.state",
				ezu."countryid" AS "customer.countryid", ezu."langid" AS "customer.languageid",
				ezu."telephone" AS "customer.telephone", ezu."email" AS "customer.email",
				ezu."telefax" AS "customer.telefax", ezu."website" AS "customer.website",
				ezu."birthday" AS "customer.birthday", ezu."vdate" AS "customer.vdate",
				ezu."password_hash" AS "customer.password", ezu."ctime" AS "customer.ctime",
				ezu."mtime" AS "customer.mtime", ezu."editor" AS "customer.editor",
				ezs."is_enabled" as "customer.status"
			FROM "ezuser" AS ezu
			LEFT JOIN "ezuser_setting" as ezs ON ezu."contentobject_id" = ezs."user_id"
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
				SELECT DISTINCT ezu."contentobject_id"
				FROM "ezuser" AS ezu
				LEFT JOIN "ezuser_setting" as ezs ON ezu."contentobject_id" = ezs."user_id"
				:joins
				WHERE :cond
				LIMIT 10000 OFFSET 0
			) AS list
		',
	),
);
