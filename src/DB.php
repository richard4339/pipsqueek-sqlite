<?php

/**
 * pipsqueek-sqlite
 * @author Richard Lynskey <richard@mozor.net>
 * @copyright Copyright (c) 2017, Richard Lynskey
 * @version 1.0.3
 *
 * Built 2017-07-15 11:18 CDT by Richard Lynskey
 *
 */

namespace Pipsqueek\DB;

use Medoo\Medoo;
use PDO;

/**
 * Class DB
 * @package Pipsqueek
 */
class DB extends Medoo
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
     * @param string|null $options
     * @throws \Exception
     */
    function __construct($options = null)
    {
        if(is_null($options)) {
            if (!defined('DBPATH')) {
                throw new \Exception('No DBPATH was supplied or defined as a global');
            }
        }

        if(!is_array($options)) {
            $dbpath = $options;
        } else {
            $dbpath = $options['database_file'];
        }
        if (!file_exists($dbpath)) {
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
     * @param array|null $join
     * @param array|null $columns
     * @param array|null $where
     * @return array|bool|mixed
     */
    public function getRandom($table, $join = null, $columns = null, $where = null)
    {
        $map = [];
        $stack = [];
        $column_map = [];

        $column = $where === null ? $join : $columns;

        $is_single_column = (is_string($column) && $column !== '*');

        $query = $this->exec($this->selectContext($table, $map, $join, $columns, $where) . ' ORDER BY RANDOM() LIMIT 1', $map);

        if ($query)
        {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            if (isset($data[ 0 ]))
            {
                if ($column === '*')
                {
                    return $data[ 0 ];
                }

                $this->columnMap($columns, $column_map);

                $this->dataMap($data[ 0 ], $columns, $column_map, $stack);

                if ($is_single_column)
                {
                    return $stack[ $column_map[ $column ][ 0 ] ];
                }

                return $stack;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * @deprecated 1.0.3 This function was broken by Medoo updates. Use getRandom() for now.
     *
     * @param string $table
     * @param int $limit
     * @param array $join
     * @param string|array|null $columns
     * @param array|null $where
     * @return array|bool
     */
    function selectRandom($table, $limit, $join, $columns = null, $where = null) {
        $query = $this->selectContext($table, $join, $columns, $where);

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