<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * ESputnik configuration.
 */
class Config extends ArrayList
{

    protected $fields = [
        'login' => null,
        'password' => null,
        'protocolVersion' => 'v1',
        'timeOut' => 30,
        'apiUrl' => 'https://esputnik.com/api',
    ];

    /**
     * Returns UserPwd string.
     *
     * @return string
     */
    public function getUserPwd()
    {
        return $this->getLogin() . ':' . $this->getPassword();
    }
}
