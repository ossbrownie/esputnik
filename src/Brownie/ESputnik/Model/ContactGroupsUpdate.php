<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * List of segment names new/updated contacts will be added to.
 * List of segment names new/updated contacts will be excluded from.
 *
 * @method ContactGroupsUpdate      setAddNames(array $names)       Sets the names of the groups to add.
 * @method ContactGroupsUpdate      setExcludeNames(array $names)   Sets the names of the groups to delete.
 * @method array                    getAddNames()                   Gets the names of the groups to add.
 * @method array                    getExcludeNames()               Gets the names of the groups to delete.
 */
class ContactGroupsUpdate extends ArrayList
{

    protected $fields = [
        'addNames' => null,
        'excludeNames' => null,
    ];
}
