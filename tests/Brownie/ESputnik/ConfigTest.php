<?php

use Brownie\ESputnik\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Config
     */
    protected $configClass;

    protected function setUp()
    {
        $this->configClass = new Config();
    }

    protected function tearDown()
    {
        $this->configClass = null;
    }

    public function testSetGetLogin()
    {
        $login = 'login';
        $this->configClass->setLogin($login);
        $this->assertEquals($login, $this->configClass->getLogin());
    }

    public function testSetGetPassword()
    {
        $password = 'password';
        $this->configClass->setPassword($password);
        $this->assertEquals($password, $this->configClass->getPassword());
    }

    public function testSetGetProtocolVersion()
    {
        $protocolVersion = 'v0';
        $this->configClass->setProtocolVersion($protocolVersion);
        $this->assertEquals($protocolVersion, $this->configClass->getProtocolVersion());
    }

    public function testSetGetTimeOut()
    {
        $timeOut = 100;
        $this->configClass->setTimeOut($timeOut);
        $this->assertEquals($timeOut, $this->configClass->getTimeOut());
    }

    public function testSetGetApiUrl()
    {
        $apiUrl = 'http://localhost/api';
        $this->configClass->setApiUrl($apiUrl);
        $this->assertEquals($apiUrl, $this->configClass->getApiUrl());
    }

    public function testGetUserPwd()
    {
        $login = 'login';
        $password = 'password';
        $this
            ->configClass
            ->setLogin($login)
            ->setPassword($password);
        $this->assertEquals($login . ':' . $password, $this->configClass->getUserPwd());
    }
}
