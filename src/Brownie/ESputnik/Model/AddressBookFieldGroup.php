<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\EntityList;

/**
 * Enumerating the list of additional fields that are bound to directory.
 */
class AddressBookFieldGroup extends EntityList
{

    /**
     * Key name of the block.
     * @var string
     */
    protected $keyName = 'fieldGroups';

    /**
     * The name of the list of additional fields.
     * @var string
     */
    private $name;

    /**
     * The key of the list of additional fields.
     * @var string
     */
    private $profileKey;

    /**
     * Sets incoming data.
     *
     * @param string    $name           The name of the list of additional fields.
     * @param string    $profileKey     The key of the list of additional fields.
     */
    public function __construct($name, $profileKey)
    {
        parent::__construct();
        $this
            ->setName($name)
            ->setProfileKey($profileKey);
    }

    /**
     * Sets name.
     * Returns the current object.
     *
     * @param string    $name   Name of the list.
     *
     * @return self
     */
    private function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Sets profile key.
     * Returns the current object.
     *
     * @param string    $profileKey     Key of the list.
     *
     * @return self
     */
    private function setProfileKey($profileKey)
    {
        $this->profileKey = $profileKey;
        return $this;
    }

    /**
     * Add book field.
     * Returns the current object.
     *
     * @param AddressBookField      $addressBookField   Book field.
     *
     * @return self
     */
    public function add(AddressBookField $addressBookField)
    {
        parent::append($addressBookField);
        return $this;
    }

    /**
     * Returns name of the list.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns key of the list.
     *
     * @return string
     */
    public function getProfileKey()
    {
        return $this->profileKey;
    }

    /**
     * Returns the fields as an array.
     *
     * @return AddressBookField[]
     */
    public function getFields()
    {
        return $this->toArray();
    }
}
