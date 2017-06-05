<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\EntityList;
use Brownie\ESputnik\Model\Base\Channel;

/**
 * List of media channels. You can add maximum two channels of the same type.
 * It is necessary to specify at least one channel.
 */
class ChannelList extends EntityList
{

    protected $keyName = 'channels';

    /**
     * Add channel to list.
     * Returns the current object.
     *
     * @param Channel $channel Media channel.
     *
     * @return self
     */
    public function add(Channel $channel)
    {
        parent::append($channel);
        return $this;
    }
}
