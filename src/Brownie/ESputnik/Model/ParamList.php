<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\EntityList;

/**
 * List of parameters.
 */
class ParamList extends EntityList
{

    protected $keyName = 'params';

    public function add(Parameter $parameter)
    {
        parent::append($parameter);
        return $this;
    }
}
