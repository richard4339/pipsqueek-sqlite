<?php

class DBTest extends PHPUnit_Framework_TestCase
{

    public function testNoDBPath()
    {

        $this->expectExceptionMessage('No DBPATH was supplied or defined as a global');

    }

}
