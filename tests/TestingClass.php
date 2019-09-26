<?php
use \PHPUnit\Framework\TestCase;


class TestingClass extends TestCase
{
    #Testing connection to databse
    public function testConnection()
    {
        include_once ('../php/db_connect.php');

        $expected = "Connection established";
        $this->expectOutputString($expected);

    }

}
