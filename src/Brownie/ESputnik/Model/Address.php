<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * Contact full address.
 *
 * @method Address setRegion($region)       Sets region.
 * @method Address setTown($town)           Sets town.
 * @method Address setAddress($address)     Sets address.
 * @method Address setPostcode($postcode)   Sets postcode.
 */
class Address extends ArrayList
{

    protected $fields = [
        'region' => null,
        'town' => null,
        'address' => null,
        'postcode' => null,
    ];

    /**
     * Returns the fields as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->fields;
    }
}
