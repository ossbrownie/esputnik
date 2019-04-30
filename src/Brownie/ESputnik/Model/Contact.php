<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Exception\ValidateException;
use Brownie\ESputnik\Model\Base\ArrayList;
use Brownie\ESputnik\Model\Base\Channel;

/**
 * @method Contact      setId($id)                          Set id.
 * @method Contact      setFirstName($firstName)            Set first name.
 * @method Contact      setLastName($lastName)              Set last name.
 * @method Contact      setChannelList($channelList)        Set channel list.
 * @method Contact      setAddress($address)                Set address.
 * @method Contact      setFieldList($fieldList)            Set field list.
 * @method Contact      setContactKey($contactKey)          Set contact key.
 * @method Contact      setAddressBookId($addressBookId)    Set address book id.
 * @method Contact      setOrdersInfo($ordersInfo)          Set order info.
 * @method Contact      setGroupList($groups)               Set group list.
 * @method int          getId()                             Get id.
 * @method string       getFirstName()                      Get first name.
 * @method string       getLastName()                       Get last name.
 * @method ChannelList  getChannelList()                    Get channel list.
 * @method Address      getAddress()                        Get address.
 * @method FieldList    getFieldList()                      Get field list.
 * @method string       getContactKey()                     Get contact key.
 * @method int          getAddressBookId()                  Get address book id.
 * @method OrdersInfo   getOrdersInfo()                     Get orders info.
 * @method Grouplist    getGroupList()                      Get group list.
 */
class Contact extends ArrayList
{

    protected $fields = [
        'id' => null,
        'firstName' => null,
        'lastName' => null,
        'channelList' => null,
        'address' => null,
        'fieldList' => null,
        'contactKey' => null,
        'addressBookId' => null,
        'ordersInfo' => null,
        'groupList' => null
    ];

    public function getKeyName()
    {
        return 'contact';
    }

    /**
     * Validates contact data.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        if (!$this->getChannelList() || ($this->getChannelList() && !$this->getChannelList()->count())) {
            throw new ValidateException('Contact does not contain any channel');
        }
    }

    /**
     * Returns the contact as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];

        if ($this->getId()) {
            $data['id'] = $this->getId();
        }

        if ($this->getFirstName()) {
            $data['firstName'] = $this->getFirstName();
        }

        if ($this->getLastName()) {
            $data['lastName'] = $this->getLastName();
        }

        $data[$this->getChannelList()->getKeyName()] = array_map(
            function (Channel $channel) {
                return $channel->toArray();
            }, $this->getChannelList()->toArray()
        );

        if ($this->getAddress()) {
            $data['address'] = $this->getAddress()->toArray();
        }

        if ($this->getFieldList()) {
            $data[$this->getFieldList()->getKeyName()] = array_map(
                function (Field $field) {
                    return $field->toArray();
                }, $this->getFieldList()->toArray()
            );
        }

        if ($this->getContactKey()) {
            $data['contactKey'] = $this->getContactKey();
        }

        if ($this->getAddressBookId()) {
            $data['addressBookId'] = $this->getAddressBookId();
        }

        if ($this->getOrdersInfo()) {
            $data['ordersInfo'] = $this->getOrdersInfo()->toArray();
        }

        if ($this->getGroupList()) {
            $data['groups'] = $this->getGroupList()->toArray();
        }

        return $data;
    }
}
