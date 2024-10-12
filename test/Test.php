<?php

namespace tests;


use Mappify\Mapper\RawToObject;
use Mappify\Mapper\User;
use PHPUnit\Framework\TestCase;

class test extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function withoutOption()
    {
        $raw =
            [
              "id"=>3,
              "name"=>"proxyMates"
            ];

        $rawToObject = new RawToObject();

        $result = $rawToObject->getObject($raw,User::class,null);

        self::assertInstanceOf(User::class,$result);

    }

    /**
     * @test
     * @return void
     */
    public function withOption()
    {
        $raw =
            [
                "user_id"=>3,
                "name"=>"proxyMates"
            ];

        $rawToObject = new RawToObject();

        $result = $rawToObject->getObject($raw,User::class,["id"=>"user_id"]);

        self::assertInstanceOf(User::class,$result);
        self::assertNotEmpty($result->getId());

    }
}