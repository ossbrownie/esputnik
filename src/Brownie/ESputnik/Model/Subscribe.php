<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

/**
 * Subscribed contact.
 */
class Subscribe
{

    /**
     * Group list.
     *
     * @var GroupList
     */
    private $groupList;

    /**
     * Form type.
     *
     * @var string
     */
    private $formType = '';

    /**
     * Initializes the data.
     */
    public function __construct()
    {
        $this->createGroupList();
    }

    /**
     * Create empty group list.
     */
    private function createGroupList()
    {
        $this->groupList = new GroupList();
    }

    /**
     * Sets form type.
     * Returns the current object.
     *
     * @param string    $formType   Set form type.
     *
     * @return self
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
        return $this;
    }

    /**
     * Returns group list.
     *
     * @return GroupList
     */
    public function getGroups()
    {
        return $this->groupList;
    }

    /**
     * Returns form type.
     *
     * @return string
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * Validates contact data.
     */
    public function validate()
    {
    }

    /**
     * Returns the subscribe as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];

        if ($this->getGroups()) {
            $data[$this->getGroups()->getKeyName()] = array_map(
                function (Group $group) {
                    return $group->getName();
                }, $this->getGroups()->toArray()
            );
        }

        if ($this->getFormType()) {
            $data['formType'] = $this->getFormType();
        }

        return $data;
    }
}
