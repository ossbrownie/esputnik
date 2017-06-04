<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model\Base;

/**
 *
 */
abstract class EntityList
{

    private $list;

    public function __construct()
    {
        $this->createList();
    }

    private function createList()
    {
        $this->list = new \ArrayIterator();
    }

    /**
     * @return \ArrayIterator
     */
    private function getList()
    {
        return $this->list;
    }

    public function append($entity)
    {
        $this->getList()->append($entity);
    }

    public function getKeyName()
    {
        return $this->keyName;
    }

    public function toArray()
    {
        return $this->getList()->getArrayCopy();
    }

    public function count()
    {
        return $this->getList()->count();
    }
}
