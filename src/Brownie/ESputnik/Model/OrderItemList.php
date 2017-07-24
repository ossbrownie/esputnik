<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\EntityList;

/**
 * Order item list.
 */
class OrderItemList extends EntityList
{

    protected $keyName = 'order_item_list';

    /**
     * Add order item.
     *
     * @param OrderItem $orderItem Order item
     *
     * @return self
     */
    public function add(OrderItem $orderItem)
    {
        parent::append($orderItem);
        return $this;
    }

    public function toArray()
    {
        return array_map(
            function (OrderItem $orderItem) {
                return $orderItem->toArray();
            }, parent::toArray()
        );
    }
}
