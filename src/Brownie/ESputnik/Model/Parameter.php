<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * Event parameter.
 *
 * @method Parameter    setName($name)      Sets parameter name.
 * @method Parameter    setValue($value)    Sets parameter value.
 */
class Parameter extends ArrayList
{

    protected $fields = [
        'name' => null,
        'value' => null,
    ];
}
