<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\EntityList;

/**
 * The catalog contains the list of additional fields
 * for contacts that are available in your organisation.
 */
class AddressBook extends EntityList
{

    /**
     * Key name of the block.
     * @var string
     */
    protected $keyName;

    /**
     * ID of this catalog.
     * @var int
     */
    private $addressBookId;

    /**
     * Catalog name.
     * @var string
     */
    private $name;

    /**
     * Sets incoming data.
     *
     * @param int       $addressBookId      ID of this catalog.
     * @param string    $name               Catalog name.
     */
    public function __construct($addressBookId, $name)
    {
        parent::__construct();
        $this
            ->setAddressBookId($addressBookId)
            ->setName($name);
    }

    /**
     * Sets ID of this catalog.
     * Returns the current object.
     *
     * @param int   $addressBookId      ID of this catalog.
     *
     * @return self
     */
    private function setAddressBookId($addressBookId)
    {
        $this->addressBookId = $addressBookId;
        return $this;
    }

    /**
     * Sets catalog name.
     * Returns the current object.
     *
     * @param string    $name   Catalog name.
     *
     * @return self
     */
    private function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns ID of this catalog.
     *
     * @return int
     */
    public function getAddressBookId()
    {
        return $this->addressBookId;
    }

    /**
     * Returns catalog name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add address field groups.
     * Returns the current object.
     *
     * @param AddressBookFieldGroup     $addressBookGroup   Field group
     *
     * @return self
     */
    public function add(AddressBookFieldGroup $addressBookGroup)
    {
        parent::append($addressBookGroup);
        return $this;
    }

    /**
     * Returns field groups.
     *
     * @return AddressBookFieldGroup[]
     */
    public function getFieldGroups()
    {
        return $this->toArray();
    }
}
