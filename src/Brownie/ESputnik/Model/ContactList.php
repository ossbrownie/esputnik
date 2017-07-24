<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\EntityList;

/**
 * Contact list.
 */
class ContactList extends EntityList
{

    protected $keyName = 'contact_list';

    public function add(Contact $contact)
    {
        parent::append($contact);
        return $this;
    }

    public function toArray()
    {
        return array_map(
            function (Contact $contact) {
                return $contact->toArray();
            }, parent::toArray()
        );
    }
}
