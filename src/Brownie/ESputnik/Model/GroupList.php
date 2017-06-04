<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\EntityList;

/**
 * List of segment names new/updated contacts will be added to.
 */
class GroupList extends EntityList
{

    protected $keyName = 'groups';

    /**
     * Add contact group.
     *
     * @param Group     $group      Contact group.
     *
     * @return self
     */
    public function add(Group $group)
    {
        parent::append($group);
        return $this;
    }
}
