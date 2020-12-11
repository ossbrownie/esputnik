<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * Recipient.
 *
 * @method string   setEmail($email)                    Set email client.
 * @method int      setContactId($id)                   Set id.
 * @method string   setLocator($email)                  Set email client.
 * @method string   setJsonParam($params)               Set json params.
 * @method bool     setExternalRequestId($external_id)  Set external id.
 * @method string   getEmail($email)                    Get email client.
 * @method int      getContactId()                      Get id.
 * @method string   getLocator($email)                  Get email client.
 * @method string   getJsonParam()                      Get json params.
 * @method string   getExternalRequestId()              Get external id.
 */
class Recipient extends ArrayList
{

    protected $fields = [
        'email' => null,
        'contactId' => null,
        'locator' => null,
        'jsonParam' => null,
        'externalRequestId' => null,
    ];
}
