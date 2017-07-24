<?php

use Brownie\ESputnik\HTTPClient\HTTPClient;
use Brownie\ESputnik\Config;
use Brownie\ESputnik\HTTPClient\Client;
use Prophecy\Prophecy\MethodProphecy;

class HTTPClientTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var HTTPClient
     */
    private $httpClientClass;

    /**
     * Client mock object.
     *
     * @var Client
     */
    private $clientMock;

    protected function setUp()
    {
        $this->clientMock = $this
            ->prophesize(Client::class);

        $config = $this
            ->prophesize(Config::class);

        $config->addMethodProphecy(
            (new MethodProphecy(
                $config,
                'getUserPwd',
                []
            ))->willReturn('login:password')
        );

        $config->addMethodProphecy(
            (new MethodProphecy(
                $config,
                'getApiUrl',
                []
            ))->willReturn('https://esputnik.com/api')
        );

        $config->addMethodProphecy(
            (new MethodProphecy(
                $config,
                'getProtocolVersion',
                []
            ))->willReturn('v1')
        );

        $config->addMethodProphecy(
            (new MethodProphecy(
                $config,
                'getTimeOut',
                []
            ))->willReturn(60)
        );

        $this->httpClientClass = new HTTPClient($this->clientMock->reveal(), $config->reveal());
    }

    protected function tearDown()
    {
        $this->httpClientClass = null;
    }

    public function testRequestVersion()
    {
        $version = '55810';
        $protocolVersion = '1.0';
        $runtime = 1.287137;

        $this
            ->clientMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->clientMock,
                    'httpRequest',
                    ['https://esputnik.com/api/v1/version', 'login:password', [], 'GET', 60]
                ))->willReturn([
                    '{"version":"' . $version . '","protocolVersion":"' . $protocolVersion . '"}',
                    200,
                    $runtime
                ])
            );

        $versionArray = $this->httpClientClass->request(200, 'version');

        $this->assertEquals($version, $versionArray['response']['version']);
        $this->assertEquals($protocolVersion, $versionArray['response']['protocolVersion']);
        $this->assertEquals($runtime, $versionArray['runtime']);
    }

    public function testRequestGroups()
    {
        $id = 1132370;
        $name = 'New Group Name';
        $type = 'Static';
        $runtime = 1.287137;

        $this
            ->clientMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->clientMock,
                    'httpRequest',
                    ['https://esputnik.com/api/v1/groups', 'login:password', [], 'GET', 60]
                ))->willReturn([
                    '[{"id":' . $id . ',"name":"' . $name . '","type":"' . $type . '"}]',
                    200,
                    $runtime
                ])
            );

        $groupsArray = $this->httpClientClass->request(200, 'groups');

        $this->assertCount(1, $groupsArray['response']);
        $this->assertEquals($id, $groupsArray['response'][0]['id']);
        $this->assertEquals($name, $groupsArray['response'][0]['name']);
        $this->assertEquals($type, $groupsArray['response'][0]['type']);
        $this->assertEquals($runtime, $groupsArray['runtime']);
    }
}
