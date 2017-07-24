<?php

use Brownie\ESputnik\Model\Address;

class AddressTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var Address
     */
    private $address;

    protected function setUp()
    {
        $this->address = new Address([
            'region' => 1,
            'town' => 2,
            'address' => 3,
            'postcode' => 4,
        ]);
    }

    protected function tearDown()
    {
        $this->address = null;
    }

    public function testSetGet()
    {
        $this->assertEquals([
            'region' => 1,
            'town' => 2,
            'address' => 3,
            'postcode' => 4,
        ], $this->address->toArray());

        $this->address->setRegion(5);
        $this->address->setTown(6);
        $this->address->setAddress(7);
        $this->address->setPostcode(8);

        $this->assertEquals([
            'region' => 5,
            'town' => 6,
            'address' => 7,
            'postcode' => 8,
        ], $this->address->toArray());
    }
}
