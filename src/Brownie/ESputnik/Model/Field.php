<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * Additional field of contact.
 */
class Field extends ArrayList
{

    protected $fields = [
        'id' => null,
        'value' => null,
    ];

    /**
     * Sets incoming data.
     *
     * @param int       $id         ID field.
     * @param string    $value      Value.
     */
    public function __construct($id, $value)
    {
        parent::__construct([
            'id' => $id,
            'value' => $value
        ]);
    }

    /**
     * Returns the field list as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->fields;
    }
}
