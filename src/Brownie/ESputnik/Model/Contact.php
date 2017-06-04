<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Exception\Validate;
use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * @method Contact  setId($id)                      Set id.
 * @method int      getId()                         Get id.
 * @method Contact  setFirstName($firstName)        Set first name.
 * @method Contact  setLastName($lastName)          Set last name.
 * @method Contact  setChannelList($channelList)    Set channel list.
 * @method Contact  setAddress($address)            Set address.
 * @method Contact  setFieldList($fieldList)        Set field list.
 * @method Contact  setContactKey($contactKey)      Set contact key.
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
    ];

    public function getKeyName()
    {
        return 'contact';
    }

    /**
     * Validates contact data.
     *
     * @throws Validate
     */
    public function validate()
    {
        if (!$this->getChannelList() || ($this->getChannelList() && !$this->getChannelList()->count())) {
            throw new Validate('Contact does not contain any channel');
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

        return $data;
    }
}
