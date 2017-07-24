<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * Property for determining uniqueness of the contact.
 *
 * @method ContactDedupe    setDedupe($dedupe)  Set dedupe.
 * @method string           getDedupe()         Get dedupe.
 * @method int              getFieldId()        Get field ID.
 */
class ContactDedupe extends ArrayList
{

    const DEDUPE_EMAIL = 'email';

    const DEDUPE_SMS = 'sms';

    const DEDUPE_EMAIL_OR_SMS = 'email_or_sms';

    const DEDUPE_ID = 'id';

    const DEDUPE_FIELD_ID = 'fieldId';

    protected $fields = [
        'dedupe' => self::DEDUPE_EMAIL,
        'fieldId' => null,
    ];

    /**
     * Set field ID for dedupe.
     *
     * @param $fieldId
     *
     * @return self
     */
    public function setFieldId($fieldId)
    {
        $this->setDedupe(self::DEDUPE_FIELD_ID);
        $this->fields['fieldId'] = $fieldId;
        return $this;
    }
}
