<?php

/**
 * pipsqueek-sqlite
 * @author Richard Lynskey <richard@mozor.net>
 * @copyright Copyright (c) 2017, Richard Lynskey
 * @version 1.0
 *
 * Built 2017-01-21 12:45 CST by Richard Lynskey
 *
 */

namespace Pipsqueek;

use medoo;
use PDO;

/**
 * Class DB
 * @package Pipsqueek
 */
class DB extends medoo
{

    /**
     * @var string
     */
    const COMMANDTABLE = "commands";

    /**
     * @var string
     */
    const USERTABLE = "users";

    /**
     * @var string
     */
    const CHATTABLE = "chats";

    /**
     * @var string Database path. Defaults to the DBPATH global (if defined) if the argument is not passed to the constructor
     */
    private $_dbpath = '';

    /**
     * DB constructor.
     * @param string|null $dbpath Defaults to the DBPATH global if the NULL default is passed
     * @throws \Exception
     */
    function __construct($dbpath = null)
    {
        if(is_null($dbpath)) {
            if (!defined('DBPATH')) {
                throw new \Exception('No DBPATH was supplied or defined as a global');
            } else {
                $dbpath = DBPATH;
            }
        }

        if(!file_exists($dbpath)) {
            throw new \Exception('The supplied DBPATH does not exist');
        }

        $this->_dbpath = $dbpath;

        parent::__construct([
            'database_type' => 'sqlite',
            'database_file' => $this->_dbpath
        ]);
    }

    /**
     * @param string $table
     * @param int $limit
     * @param array $join
     * @param string|array|null $columns
     * @param array|null $where
     * @return array|bool
     */
    function selectRandom($table, $limit, $join, $columns = null, $where = null) {
        $query = $this->select_context($table, $join, $columns, $where);

        $query .= " ORDER BY RANDOM()";
        if(!is_null($limit)) {
            $query .= " LIMIT " . $limit;
        }

        $query = $this->query($query);

        return $query ? $query->fetchAll(
            (is_string($columns) && $columns != '*') ? PDO::FETCH_COLUMN : PDO::FETCH_ASSOC
        ) : false;
    }
}