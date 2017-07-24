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
 *
 * @method string   getVersion()            Get the version of the current API assembly.
 * @method string   getProtocolVersion()    Get API protocol version.
 */
class Version extends ArrayList
{

    protected $fields = [
        'version' => null,
        'protocolVersion' => null,
    ];
}
