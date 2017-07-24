<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * Contact's search parameters.
 *
 * @method ContactSearch    setEmail($email)                Set email.
 * @method ContactSearch    setSms($sms)                    Set SMS.
 * @method ContactSearch    setFirstname($firstName)        Set first name.
 * @method ContactSearch    setLastname($lastName)          Set last name.
 * @method ContactSearch    setStartindex($startIndex)      Set start index.
 * @method ContactSearch    setMaxrows($maxRoes)            Set the maximum number of contacts in the response.
 * @method string           getEmail()                      Get email.
 * @method string           getSms()                        Get SMS.
 * @method string           getFirstname()                  Get first name.
 * @method string           getLastname()                   Get last name.
 * @method int              getStartindex()                 Get start index.
 * @method int              getMaxrows()                    Get maximum number of contacts in the response.
 */
class ContactSearch extends ArrayList
{

    protected $fields = [
        'email' => null,
        'sms' => null,
        'firstname' => null,
        'lastname' => null,
        'startindex' => 1,
        'maxrows' => 500
    ];

    public function toArray()
    {
        return array_filter(parent::toArray());
    }
}
