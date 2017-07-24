<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\EntityList;

/**
 * Order list.
 */
class OrderList extends EntityList
{

    protected $keyName = 'orders';

    /**
     * Add order.
     *
     * @param Order $order Order.
     *
     * @return self
     */
    public function add(Order $order)
    {
        parent::append($order);
        return $this;
    }

    public function toArray()
    {
        return array_map(
            function (Order $order) {
                return $order->toArray();
            }, parent::toArray()
        );
    }

    public function validate()
    {
        array_map(
            function (Order $order) {
                return $order->validate();
            }, parent::toArray()
        );
    }
}
