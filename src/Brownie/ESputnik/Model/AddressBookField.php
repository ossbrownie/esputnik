<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * @method int      getId()                 Get id.
 * @method string   getName()               Get name.
 * @method string   getFieldKey()           Get field key.
 * @method string   getType()               Get type.
 * @method boolean  getRequired()           Get required flag.
 * @method boolean  getReadonly()           Get readonly flag.
 * @method array    getPossibleValues()     Get possible values.
 */
class AddressBookField extends ArrayList
{

    protected $fields = [
        'id' => null,
        'name' => null,
        'fieldKey' => null,
        'type' => null,
        'required' => null,
        'readonly' => null,
        'possibleValues' => null
    ];
}
