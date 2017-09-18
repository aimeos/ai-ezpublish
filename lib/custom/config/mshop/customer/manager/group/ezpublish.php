<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 */

return array(
	'groups' => array(
		'ansi' => '
			SELECT "contentobject_id", "role_id"
			FROM "ezuser_role"
			WHERE :cond AND "role_id" IS NOT NULL
			GROUP BY "contentobject_id", "role_id"
		'
	),
	'search' => array(
		'ansi' => '
			SELECT ezro."id" AS "customer.group.id", ezro."id" AS "customer.group.code",
				ezro."name" AS "customer.group.label"
			FROM "ezrole" AS ezro
			:joins
			WHERE :cond
			GROUP BY ezro."id", ezro."label" /*-columns*/ , :columns /*columns-*/
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		'
	),
	'count' => array(
		'ansi' => '
			SELECT COUNT(*) AS "count"
			FROM (
				SELECT DISTINCT ezro."id"
				FROM "ezrole" AS ezro
				:joins
				WHERE :cond
				LIMIT 10000 OFFSET 0
			) AS list
		'
	),
);
