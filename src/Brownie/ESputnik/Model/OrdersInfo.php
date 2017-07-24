<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * Orders info.
 */
class OrdersInfo extends ArrayList
{
    protected $fields = [
        'lastDate' => null,
        'count' => null,
    ];
}
