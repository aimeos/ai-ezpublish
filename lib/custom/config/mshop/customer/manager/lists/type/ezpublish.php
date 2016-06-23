<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */

return array(
	'insert' => array(
		'ansi' => '
			INSERT INTO "ezuser_list_type"( "siteid", "code", "domain", "label", "status",
				"mtime", "editor", "ctime" )
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "ezuser_list_type"
			SET "siteid"=?, "code" = ?, "domain" = ?, "label" = ?, "status" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
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
			SELECT ezulity."id" AS "customer.lists.type.id", ezulity."siteid" AS "customer.lists.type.siteid",
				ezulity."code" AS "customer.lists.type.code", ezulity."domain" AS "customer.lists.type.domain",
				ezulity."label" AS "customer.lists.type.label", ezulity."status" AS "customer.lists.type.status",
				ezulity."mtime" AS "customer.lists.type.mtime", ezulity."editor" AS "customer.lists.type.editor",
				ezulity."ctime" AS "customer.lists.type.ctime"
			FROM "ezuser_list_type" AS ezulity
			:joins
			WHERE
				:cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
	),
	'count' => array(
		'ansi' => '
			SELECT COUNT(*) AS "count"
			FROM (
				SELECT DISTINCT ezulity."id"
				FROM "ezuser_list_type" AS ezulity
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
);
