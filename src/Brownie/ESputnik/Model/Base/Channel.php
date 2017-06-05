<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model\Base;

abstract class Channel extends ArrayList
{

    protected $fields = [
        'value' => null,
    ];

    public function __construct($value)
    {
        parent::__construct([
            'value' => $value
        ]);
    }

    private function getType()
    {
        return $this->type;
    }

    public function toArray()
    {
        return [
            'type' => $this->getType(),
            'value' => $this->getValue()
        ];
    }
}
