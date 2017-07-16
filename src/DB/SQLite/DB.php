<?php

/**
 * pipsqueek-sqlite
 * @author Richard Lynskey <richard@mozor.net>
 * @copyright Copyright (c) 2017, Richard Lynskey
 * @version 1.1.0
 *
 * Built 2017-07-15 11:21 CDT by Richard Lynskey
 *
 */

namespace Pipsqueek\DB\SQLite;

use Medoo\Medoo;
use PDO;

/**
 * Class DB
 * @package Pipsqueek\DB\SQLite
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
     * Gets a random entry from the table with the supplied criteria
     *
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
}