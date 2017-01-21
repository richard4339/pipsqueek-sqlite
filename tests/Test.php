<?php

class DBTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No DBPATH was supplied or defined as a global
     */
    public function testNoDBPath()
    {

        new \Pipsqueek\DB();

    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage The supplied DBPATH does not exist
     */
    public function testInvalidDBPath()
    {

        new \Pipsqueek\DB('/wrong/path');

    }

    public function testSampleFileExists()
    {

        $this->assertFileExists(__DIR__ . '/sample.db');

    }

    public function testValidDBPath()
    {

        new \Pipsqueek\DB(__DIR__ . '/sample.db');

    }

}
