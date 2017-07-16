<?php

/**
 * Class DBTest
 */
class DBTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No DBPATH was supplied or defined as a global
     */
    public function testNoDBPath()
    {

        new \Pipsqueek\DB\SQLite\DB();

    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage The supplied DBPATH does not exist
     */
    public function testInvalidDBPath()
    {

        new \Pipsqueek\DB\SQLite\DB('/wrong/path');

    }

    public function testSampleFileExists()
    {

        $this->assertFileExists(__DIR__ . '/sample.db');

    }

    public function testValidDBPath()
    {

        new \Pipsqueek\DB\SQLite\DB(__DIR__ . '/sample.db');

    }

    public function testArrayOptions()
    {

        new \Pipsqueek\DB\SQLite\DB([
            'database_type' => 'sqlite',
            'database_file' => __DIR__ . '/sample.db'
        ]);

    }

}
