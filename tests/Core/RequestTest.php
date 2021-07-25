<?php

namespace Tests\Core;

use Contentus\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    private Request $request;


    private function init()
    {
        $this->request = new Request();
    }


    /////Start test getPath/////
    public function testGetPathExpectReturnSlash()
    {
        $this->init();

        $this->assertSame("/", $this->request->getPath());
    }


    public function testGetPathExpectReturnPathWithoutGetParams()
    {
        $this->init();
        $_SERVER['REQUEST_URI'] = "test?param=true";

        $this->assertSame("test", $this->request->getPath());
    }


    public function testGetPathExpectReturnPath()
    {
        $this->init();
        $_SERVER['REQUEST_URI'] = "test";

        $this->assertSame("test", $this->request->getPath());
    }
    /////End test getPath/////


    /////Start test getMethod/////
    public function testGetMethodAndExpectMethodsLowercase()
    {
        $this->init();

        $_SERVER['REQUEST_METHOD'] = "GET";

        $this->assertEquals("get", $this->request->getMethod());
    }
    /////End test getMethod/////
}
