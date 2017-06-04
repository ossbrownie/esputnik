<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * Protocol version.
 */
class Version extends ArrayList
{

    protected $fields = [
        'version' => null,
        'protocolVersion' => null,
    ];
}
