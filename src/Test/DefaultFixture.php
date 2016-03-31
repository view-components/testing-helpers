<?php

namespace ViewComponents\TestingHelpers\Test;

use Nayjest\Collection\Extended\ObjectCollection;

class DefaultFixture
{
    private static $data;

    /**
     * @return array
     */
    public static function getArray()
    {
        if (self::$data === null) {
            self::$data = include TESTING_HELPERS_DIR . '/resources/fixtures/users.php';
        }
        return self::$data;
    }

    /**
     * @return object[]
     */
    public static function getObjects()
    {
        $objects = [];
        foreach (self::getArray() as $arrayItem) {
            $objects[] = (object)$arrayItem;
        }
        return $objects;
    }

    /**
     * @return ObjectCollection
     */
    public static function getCollection()
    {
        return new ObjectCollection(self::getObjects());
    }

    /**
     * @return int
     */
    public static function getTotalCount()
    {
        return count(self::getArray());
    }
}
