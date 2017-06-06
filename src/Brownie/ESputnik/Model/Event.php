<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 *  Generate event.
 */
class Event extends ArrayList
{

    protected $fields = [
        'eventTypeKey' => null,
        'keyValue' => null,
        'params' => null,
    ];

    /**
     * Returns the field list as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($entity) {
            if (is_object($entity)) {
                return array_map(function ($entity) {
                    return $entity->toArray();
                }, $entity->toArray());
            }
            return $entity;
        }, $this->fields);
    }
}
