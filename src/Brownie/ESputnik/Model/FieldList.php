<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\EntityList;

/**
 * An additional list for contacts.
 */
class FieldList extends EntityList
{

    protected $keyName = 'fields';

    /**
     * Add field to list.
     * Returns the current object.
     *
     * @param Field     $field  Field contact.
     *
     * @return self
     */
    public function add(Field $field)
    {
        parent::append($field);
        return $this;
    }
}
