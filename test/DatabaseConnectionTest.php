<?php
namespace ViewComponents\TestingHelpers\SelfTest;


use PDO;
use PHPUnit_Framework_TestCase;

class DatabaseConnectionTest extends PHPUnit_Framework_TestCase
{

    public function test()
    {
        $connection = \ViewComponents\TestingHelpers\dbConnection();
        self::assertInstanceOf(PDO::class, $connection);

    }
}