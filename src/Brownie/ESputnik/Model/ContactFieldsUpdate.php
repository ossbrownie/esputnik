<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;

/**
 * List of contacts' fields which will be updated.
 * List of custom fields IDs which will be updated.
 *
 * @method ContactFieldsUpdate      setFieldNames(array $fields)                Set list of contacts' fields.
 * @method ContactFieldsUpdate      setCustomFieldIDS(array $customFieldsIDs)   Set list of custom fields IDs.
 * @method array                    getFieldNames()                             Get list of contacts' fields.
 * @method array                    getCustomFieldIDS()                         Get list of custom fields IDs.
 */
class ContactFieldsUpdate extends ArrayList
{

    const FIRST_NAME = 'firstName';

    const LAST_NAME = 'lastName';

    const CONTACT_KEY = 'contactKey';

    const ORDERS_INFO = 'ordersInfo';

    const EMAIL = 'email';

    const SMS = 'sms';

    const ADDRESS = 'address';

    const TOWN = 'town';

    const REGION = 'region';

    const POSTCODE = 'postcode';

    const MOBILEPUSH = 'mobilepush';

    const WEBPUSH = 'webpush';
    protected $fields = [
        'fieldNames' => [self::FIRST_NAME, self::LAST_NAME],
        'customFieldIDS' => null,
    ];
}
