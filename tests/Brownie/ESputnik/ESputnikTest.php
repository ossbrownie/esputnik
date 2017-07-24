<?php

use Brownie\ESputnik\ESputnik;
use Brownie\ESputnik\Config;
use Brownie\ESputnik\HTTPClient\Client;
use Brownie\ESputnik\HTTPClient\HTTPClient;
use Prophecy\Prophecy\MethodProphecy;
use Brownie\ESputnik\Model\Contact;
use Brownie\ESputnik\Model\Subscribe;
use Brownie\ESputnik\Model\Event;

class ESputnikTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var ESputnik
     */
    protected $eSputnikClass;

    /**
     * HTTPClient mock object.
     *
     * @var HTTPClient
     */
    protected $httpClient;

    protected function setUp()
    {
        $client = $this
            ->prophesize(Client::class)
            ->reveal();

        $config = $this
            ->prophesize(Config::class)
            ->reveal();

        $this->httpClient = $this
            ->prophesize(HTTPClient::class)
            ->willBeConstructedWith([
                $client,
                $config
            ]);

        $this->eSputnikClass = new ESputnik($this->httpClient->reveal());
    }

    protected function tearDown()
    {
        $this->eSputnikClass = null;
    }

    public function testVersion()
    {
        $version = '55810';
        $protocolVersion = '1.0';

        $this
            ->httpClient
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->httpClient,
                    'request',
                    [200, 'version']
                ))->willReturn([
                    'response' => [
                        'version' => $version,
                        'protocolVersion' => $protocolVersion
                    ],
                    'runtime' => '1.287137'
                ])
            );

        $modelVersion = $this->eSputnikClass->version();

        $this->assertEquals($version, $modelVersion->getVersion());
        $this->assertEquals($protocolVersion, $modelVersion->getProtocolVersion());
    }

    public function testContactSubscribe()
    {
        $id = 221003351;

        $contactMock = $this
            ->prophesize(Contact::class);

        $contactMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $contactMock,
                    'validate',
                    []
                ))->willReturn(null)
            );

        $contactMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $contactMock,
                    'getKeyName',
                    []
                ))->willReturn('contact')
            );

        $contactMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $contactMock,
                    'toArray',
                    []
                ))->willReturn([])
            );

        $contact = $contactMock->reveal();

        $subscribeMock = $this
            ->prophesize(Subscribe::class);

        $subscribeMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $subscribeMock,
                    'validate',
                    []
                ))->willReturn(null)
            );

        $subscribeMock
            ->addMethodProphecy(
            (new MethodProphecy(
                $subscribeMock,
                'toArray',
                []
            ))->willReturn([])
        );

        $subscribe = $subscribeMock->reveal();

        $this
            ->httpClient
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->httpClient,
                    'request',
                    [200, 'contact/subscribe', ['contact' => []], 'POST']
                ))->willReturn([
                    'response' => [
                        'id' => $id,
                    ],
                    'runtime' => '1.287137'
                ])
            );

        $contactSubscribe = $this->eSputnikClass->contactSubscribe($contact, $subscribe);

        $this->assertEquals($id, $contactSubscribe->getId());
    }

    public function testAddressbooks()
    {
        $addressBookId = 777;
        $addressBookName = 'Main list';
        $addressBookFieldGroupName = 'Base group';
        $addressBookFieldGroupProfileKey = 'BASE_GROUP';
        $addressBookFieldGroupFieldsId = '10000';
        $addressBookFieldGroupFieldsName = 'My date';
        $addressBookFieldGroupFieldsFieldKey = 'MY_DATE';
        $addressBookFieldGroupFieldsType = 'date';
        $addressBookFieldGroupFieldsRequired = 'false';
        $addressBookFieldGroupFieldsReadonly = 'false';
        $addressBookFieldGroupFieldsPossibleValues = ['2017-01-01', '2017-02-02'];

        $this
            ->httpClient
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->httpClient,
                    'request',
                    [200, 'addressbooks']
                ))->willReturn([
                    'response' => [
                        'addressBook' => [
                            'addressBookId' => $addressBookId,
                            'name' => $addressBookName,
                            'fieldGroups' => [
                                [
                                    'name' => $addressBookFieldGroupName,
                                    'profileKey' => $addressBookFieldGroupProfileKey,
                                    'fields' => [
                                        [
                                            'id' => $addressBookFieldGroupFieldsId,
                                            'name' => $addressBookFieldGroupFieldsName,
                                            'fieldKey' => $addressBookFieldGroupFieldsFieldKey,
                                            'description' => [
                                                'type' => $addressBookFieldGroupFieldsType,
                                                'required' => $addressBookFieldGroupFieldsRequired,
                                                'readonly' => $addressBookFieldGroupFieldsReadonly,
                                                'allowedValues' => [
                                                    'possibleValues' => $addressBookFieldGroupFieldsPossibleValues
                                                ]
                                            ],
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ],
                    'runtime' => '1.287137'
                ])
            );

        $addressbooks = $this->eSputnikClass->addressbooks();

        /**
         * @var $addressBookFieldGroup  \Brownie\ESputnik\Model\AddressBookFieldGroup
         */
        $addressBookFieldGroup = current($addressbooks->getFieldGroups());

        /**
         * @var $addressBookFieldGroupFields    \Brownie\ESputnik\Model\AddressBookField
         */
        $addressBookFieldGroupFields = current($addressBookFieldGroup->getFields());

        $this->assertEquals($addressBookId, $addressbooks->getAddressBookId());
        $this->assertEquals($addressBookName, $addressbooks->getName());
        $this->assertEquals('fieldGroups', $addressBookFieldGroup->getKeyName());
        $this->assertEquals($addressBookFieldGroupName, $addressBookFieldGroup->getName());
        $this->assertEquals($addressBookFieldGroupProfileKey, $addressBookFieldGroup->getProfileKey());
        $this->assertEquals($addressBookFieldGroupFieldsId, $addressBookFieldGroupFields->getId());
        $this->assertEquals($addressBookFieldGroupFieldsName, $addressBookFieldGroupFields->getName());
        $this->assertEquals($addressBookFieldGroupFieldsFieldKey, $addressBookFieldGroupFields->getFieldKey());
        $this->assertEquals($addressBookFieldGroupFieldsType, $addressBookFieldGroupFields->getType());
        $this->assertEquals($addressBookFieldGroupFieldsRequired, $addressBookFieldGroupFields->getRequired());
        $this->assertEquals($addressBookFieldGroupFieldsReadonly, $addressBookFieldGroupFields->getReadonly());
        $this->assertEquals($addressBookFieldGroupFieldsPossibleValues, $addressBookFieldGroupFields->getPossibleValues());
    }

    public function testGroups()
    {
        $id = 1132370;
        $name = 'New Group Name';
        $type = 'Static';

        $this
            ->httpClient
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->httpClient,
                    'request',
                    [200, 'groups']
                ))->willReturn([
                    'response' => [
                        [
                            'id' => $id,
                            'name' => $name,
                            'type' => $type
                        ]
                    ],
                    'runtime' => '1.287137'
                ])
            );

        $groups = $this->eSputnikClass->groups();

        /**
         * @var $group  \Brownie\ESputnik\Model\Group
         */
        $group = current($groups->toArray());

        $this->assertEquals('groups', $groups->getKeyName());
        $this->assertEquals($id, $group['id']);
        $this->assertEquals($name, $group['name']);
        $this->assertEquals($type, $group['type']);
    }

    public function testEvent()
    {
        $eventMock = $this
            ->prophesize(Event::class);

        $eventMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $eventMock,
                    'toArray',
                    []
                ))->willReturn([])
            );

        $event = $eventMock->reveal();

        $this
            ->httpClient
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->httpClient,
                    'request',
                    [200, 'event', [], 'POST', true]
                ))->willReturn([
                    'response' => '',
                    'runtime' => '1.287137'
                ])
            );

        $returnStub = $this->eSputnikClass->event($event);

        $this->assertEquals(true, $returnStub);
    }

    public function testAddContact()
    {
        // STUB
    }

    public function testUpdateContact()
    {
        // STUB
    }

    public function testGetContact()
    {
        // STUB
    }

    public function testDeleteContact()
    {
        // STUB
    }

    public function testGetContacts()
    {
        // STUB
    }

    public function testUpdateContacts()
    {
        // STUB
    }

    public function testOrders()
    {
        // STUB
    }
}
