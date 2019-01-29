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
use Brownie\ESputnik\Model\Base\EntityList;

/**
 * @method Contact      setId($id)                          Set id.
 * @method Contact      setRecipients($recepients)          Set recepients.
 * @method int          getId()                             Get id.
 * @method Recepients   getRecipients()                     Get recepients.
 */
class RecipientList extends EntityList
{
    protected $keyName = 'recipients';

    /**
     * Add field to list.
     * Returns the current object.
     *
     * @param Field $field Field contact.
     *
     * @return self
     */
    public function add(Recipient $field)
    {
        parent::append($field);
        return $this;
    }

    public function toArray()
    {
        return array_map(
            function (Recipient $field) {
                return $field->toArray();
            }, parent::toArray()
        );
    }
}
