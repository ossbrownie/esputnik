<?php

use Brownie\ESputnik\Model\Subscribe;
use Brownie\ESputnik\Model\Group;
use Prophecy\Prophecy\MethodProphecy;

class SubscribeTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var Subscribe
     */
    private $subscribe;

    protected function setUp()
    {
        $this->subscribe = new Subscribe();
    }

    protected function tearDown()
    {
        $this->subscribe = null;
    }

    public function testValidate()
    {
        $this->subscribe->validate();
    }

    public function testFormType()
    {
        $formName = 'test_form';
        $subscribeModel = $this->subscribe->setFormType($formName);
        $this->assertInstanceOf('\Brownie\ESputnik\Model\Subscribe', $subscribeModel);
        $this->assertEquals($formName, $this->subscribe->getFormType());
    }

    public function testGetGroups()
    {
        $this->assertInstanceOf('\Brownie\ESputnik\Model\GroupList', $this->subscribe->getGroups());
    }

    public function testToArray()
    {
        $data = $this->subscribe->toArray();
        $this->assertNotEmpty($data);
        $this->assertEmpty($data['groups']);
    }

    public function testToArrayGetGroups()
    {

        $groupMock = $this
            ->prophesize(Group::class);

        $groupMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $groupMock,
                    'toArray',
                    []
                ))->willReturn([
                    'name' => 'tester',
                ])
            );

        $groupMock = $groupMock->reveal();

        $this->subscribe->getGroups()->add($groupMock);

        $data = $this->subscribe->toArray();

        $this->assertNotEmpty($data);
        $this->assertEquals('tester', $data['groups'][0]);
    }

    public function testToArrayGetFormType()
    {
        $formName = 'test_form';
        $this->subscribe->setFormType($formName);
        $data = $this->subscribe->toArray();
        $this->assertEquals('test_form', $data['formType']);
    }
}
