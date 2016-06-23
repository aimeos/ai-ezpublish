<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */

return array(
	'aggregate' => array(
		'ansi' => '
			SELECT "key", COUNT(DISTINCT "id") AS "count"
			FROM (
				SELECT :key AS "key", ezuli."id" AS "id"
				FROM "ezuser_list" AS ezuli
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
				AND "typeid" = ?
				AND "domain" = ?
		',
	),
	'insert' => array(
		'ansi' => '
			INSERT INTO "ezuser_list"( "parentid", "siteid", "typeid", "domain", "refid", "start", "end",
			"config", "pos", "status", "mtime", "editor", "ctime" )
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "ezuser_list"
			SET "parentid"=?, "siteid" = ?, "typeid" = ?, "domain" = ?, "refid" = ?, "start" = ?, "end" = ?,
				"config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'updatepos' => array(
		'ansi' => '
			UPDATE "ezuser_list"
				SET "pos" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
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
				AND "typeid" = ?
				AND "domain" = ?
				AND "pos" >= ?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT ezuli."id" AS "customer.lists.id", ezuli."siteid" AS "customer.lists.siteid",
				ezuli."parentid" AS "customer.lists.parentid", ezuli."typeid" AS "customer.lists.typeid",
				ezuli."domain" AS "customer.lists.domain", ezuli."refid" AS "customer.lists.refid",
				ezuli."start" AS "customer.lists.datestart", ezuli."end" AS "customer.lists.dateend",
				ezuli."config" AS "customer.lists.config", ezuli."pos" AS "customer.lists.position",
				ezuli."status" AS "customer.lists.status", ezuli."mtime" AS "customer.lists.mtime",
				ezuli."editor" AS "customer.lists.editor", ezuli."ctime" AS "customer.lists.ctime"
			FROM "ezuser_list" AS ezuli
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
				SELECT DISTINCT ezuli."id"
				FROM "ezuser_list" AS ezuli
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
);
