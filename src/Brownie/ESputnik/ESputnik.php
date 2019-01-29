<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik;

use Brownie\ESputnik\HTTPClient\HTTPClient;
use Brownie\ESputnik\Model\Address;
use Brownie\ESputnik\Model\OrdersInfo;
use Brownie\ESputnik\Model\RecipientList;
use Brownie\ESputnik\Model\Version;
use Brownie\ESputnik\Model\Subscribe;
use Brownie\ESputnik\Model\Contact;
use Brownie\ESputnik\Model\Group;
use Brownie\ESputnik\Model\GroupList;
use Brownie\ESputnik\Model\AddressBook;
use Brownie\ESputnik\Model\AddressBookFieldGroup;
use Brownie\ESputnik\Model\AddressBookField;
use Brownie\ESputnik\Model\Event;
use Brownie\ESputnik\Model\ContactSearch;
use Brownie\ESputnik\Model\ContactList;
use Brownie\ESputnik\Model\ChannelList;
use Brownie\ESputnik\Model\EmailChannel;
use Brownie\ESputnik\Model\SmsChannel;
use Brownie\ESputnik\Model\FieldList;
use Brownie\ESputnik\Model\Field;
use Brownie\ESputnik\Model\ContactDedupe;
use Brownie\ESputnik\Model\ContactFieldsUpdate;
use Brownie\ESputnik\Model\ContactGroupsUpdate;
use Brownie\ESputnik\Model\OrderList;

/**
 * ESputnik API.
 */
class ESputnik
{

    /**
     * @var HTTPClient
     */
    private $httpClient;

    /**
     * Sets incoming data.
     *
     * @param HTTPClient $httpClient HTTP client.
     */
    public function __construct(HTTPClient $httpClient)
    {
        $this->setHttpClient($httpClient);
    }

    /**
     * Sets an HTTP client.
     * Returns the current object.
     *
     * @param HTTPClient $httpClient Http client
     *
     * @return self
     */
    private function setHttpClient(HTTPClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * Returns HTTP client.
     *
     * @return HTTPClient
     */
    private function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Get protocol version.
     *
     * @return Version
     */
    public function version()
    {
        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'version'
            );

        return new Version([
            'version' => $response['response']['version'],
            'protocolVersion' => $response['response']['protocolVersion']
        ]);
    }

    /**
     * Subscribe contact.
     * Returns new Contact.
     *
     * @param Contact   $contact        Contact.
     * @param Subscribe $subscribe      Subscribe.
     *
     * @return Contact
     */
    public function contactSubscribe(Contact $contact, Subscribe $subscribe)
    {
        $contact->validate();
        $subscribe->validate();
        $data = $subscribe->toArray();
        $data[$contact->getKeyName()] = $contact->toArray();

        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'contact/subscribe',
                $data,
                HTTPClient::HTTP_METHOD_POST
            );

        return new Contact([
            'id' => $response['response']['id']
        ]);
    }

    /**
     * Get catalog list.
     *
     * @return AddressBook
     */
    public function addressbooks()
    {
        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'addressbooks'
            );

        $addressBook = new AddressBook(
            $response['response']['addressBook']['addressBookId'],
            $response['response']['addressBook']['name']
        );

        foreach ($response['response']['addressBook']['fieldGroups'] as $fieldGroup) {
            $addressBookGroup = new AddressBookFieldGroup($fieldGroup['name'], $fieldGroup['profileKey']);
            foreach ($fieldGroup['fields'] as $field) {
                $addressBookField = new AddressBookField([
                    'id' => $field['id'],
                    'name' => $field['name'],
                    'fieldKey' => $field['fieldKey'],
                    'type' => $field['description']['type'],
                    'required' => $field['description']['required'],
                    'readonly' => $field['description']['readonly']
                ]);
                if (isset($field['description']['allowedValues']['possibleValues'])) {
                    $addressBookField->setPossibleValues($field['description']['allowedValues']['possibleValues']);
                }
                $addressBookGroup->add($addressBookField);
            }
            $addressBook->add($addressBookGroup);
        }

        return $addressBook;
    }

    /**
     * Get segments.
     *
     * @return GroupList
     */
    public function groups()
    {
        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'groups'
            );

        $groups = new GroupList();
        foreach ($response['response'] as $data) {
            $group = new Group();
            $group
                ->setId($data['id'])
                ->setName($data['name'])
                ->setType($data['type']);
            $groups->add($group);
        }

        return $groups;
    }

    /**
     * Generate event.
     *
     * @param Event $event  Event.
     *
     * @return bool
     */
    public function event(Event $event)
    {
        $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'event',
                $event->toArray(),
                HTTPClient::HTTP_METHOD_POST,
                true
            );

        return true;
    }

    /**
     * Add contact.
     *
     * @param Contact $contact  Contact.
     *
     * @return Contact
     */
    public function addContact(Contact $contact)
    {
        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'contact',
                $contact->toArray(),
                HTTPClient::HTTP_METHOD_POST
            );

        return new Contact([
            'id' => $response['response']['id']
        ]);
    }

    /**
     * Update contact.
     *
     * @param Contact $contact  Contact.
     *
     * @return bool
     */
    public function updateContact(Contact $contact)
    {
        if (!$contact->getId() || (1 > $contact->getId())) {
            return false;
        }

        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'contact/' . $contact->getId(),
                $contact->toArray(),
                HTTPClient::HTTP_METHOD_PUT,
                true
            );

        if ($response['response'] == 'Contact with id=\'' . $contact->getId() . '\' has been updated') {
            return true;
        }

        return false;
    }

    /**
     * Get contact.
     *
     * @param Contact $contact  Contact.
     *
     * @return Contact
     */
    public function getContact(Contact $contact)
    {
        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'contact/' . $contact->getId(),
                [],
                HTTPClient::HTTP_METHOD_GET
            );

        return $this->createContact($response['response']);
    }

    /**
     * Delete contact.
     *
     * @param Contact $contact  Contact
     *
     * @return bool
     */
    public function deleteContact(Contact $contact)
    {
        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'contact/' . $contact->getId(),
                [],
                HTTPClient::HTTP_METHOD_DELETE,
                true
            );

        if ($response['response'] == 'Contact with id=\'' . $contact->getId() . '\' has been deleted') {
            return true;
        }

        return false;
    }

    /**
     * Search contacts.
     *
     * @param ContactSearch     $contactSearch      Search parameters.
     *
     * @return ContactList
     */
    public function getContacts(ContactSearch $contactSearch = null)
    {
        $contacts = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'contacts?' . http_build_query($contactSearch->toArray()),
                [],
                HTTPClient::HTTP_METHOD_GET
            );

        $contactList = new ContactList();
        foreach ($contacts['response'] as $contact) {
            $contactList->add($this->createContact($contact));
        }

        return $contactList;
    }

    /**
     * Update contacts.
     *
     * @param ContactList              $contactList             List of contacts (max 3000), which will be added/updated.
     * @param ContactDedupe            $dedupe                  Property for determining uniqueness of the contact.
     * @param ContactFieldsUpdate      $fieldsUpdate            List of contacts' fields which will be updated.
     * @param ContactGroupsUpdate|null $contactGroupsUpdate     List of segment names new/updated/deleted.
     * @param bool                     $restoreDeleted          Add previously deleted contacts.
     * @param null                     $eventKeyForNewContacts  Event type key identifier. Will be generated for each new contact.
     *
     * @return bool
     */
    public function updateContacts(
        ContactList $contactList,
        ContactDedupe $dedupe,
        ContactFieldsUpdate $fieldsUpdate,
        ContactGroupsUpdate $contactGroupsUpdate = null,
        $restoreDeleted = false,
        $eventKeyForNewContacts = null
    ) {
        $data = [
            'contacts' => $contactList->toArray(),
            'dedupeOn' => $dedupe->getDedupe(),
            'fieldId' => $dedupe->getFieldId(),
            'contactFields' => $fieldsUpdate->getFieldNames(),
            'customFieldsIDs' => $fieldsUpdate->getCustomFieldIDS(),
            'groupNames' => $contactGroupsUpdate ? $contactGroupsUpdate->getAddNames() : null,
            'groupNamesExclude' => $contactGroupsUpdate ? $contactGroupsUpdate->getExcludeNames() : null,
            'restoreDeleted' => $restoreDeleted,
            'eventKeyForNewContacts' => $eventKeyForNewContacts
        ];

        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'contacts',
                $data,
                HTTPClient::HTTP_METHOD_POST

            );

        if (isset($response['response']['id']) && (0 == $response['response']['id'])) {
            return $response['response']['asyncSessionId'];
        }

        return false;
    }

    /**
     * SmartSend message.
     *
     * @param int                      $message_id              ID message for send
     * @param RecipientList            $recipientList           List users and params for send
     *
     * @return bool
     */
    public function sendSmartMessage(
        int $message_id,
        RecipientList $recipientList
    ) {
        $data = [
            'recipients' => $recipientList->toArray(),
        ];

        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                "message/{$message_id}/smartsend",
                $data,
                HTTPClient::HTTP_METHOD_POST

            );

        if (isset($response['response']['id']) && (0 == $response['response']['id'])) {
            return $response['response']['asyncSessionId'];
        }

        return false;
    }

    /**
     * Creates a contact model for arguments.
     *
     * @param array $contactFromResponse    Arguments.
     *
     * @return Contact
     */
    private function createContact($contactFromResponse)
    {
        $contact = new Contact([
            'id' => $contactFromResponse['id']
        ]);

        if (isset($contactFromResponse['firstName'])) {
            $contact->setFirstName($contactFromResponse['firstName']);
        }

        if (isset($contactFromResponse['lastName'])) {
            $contact->setLastName($contactFromResponse['lastName']);
        }

        if (isset($contactFromResponse['address'])) {
            $address = new Address([
                'region' => $contactFromResponse['address']['region'],
                'town' => $contactFromResponse['address']['town'],
                'address' => $contactFromResponse['address']['address'],
                'postcode' => $contactFromResponse['address']['postcode'],
            ]);
            $contact->setAddress($address);
        }

        if (isset($contactFromResponse['channels'])) {
            $channelList = new ChannelList();
            foreach ($contactFromResponse['channels'] as $channel) {
                if ('email' == $channel['type']) {
                    $channelList->add(new EmailChannel([
                        'value' => $channel['value']
                    ]));
                }
                if ('sms' == $channel['type']) {
                    $channelList->add(new SmsChannel([
                        'value' => $channel['value']
                    ]));
                }
            }
            $contact->setChannelList($channelList);
        }

        if (isset($contactFromResponse['addressBookId'])) {
            $contact->setAddressBookId($contactFromResponse['addressBookId']);
        }

        if (isset($contactFromResponse['fields'])) {
            $fieldList = new FieldList();
            foreach ($contactFromResponse['fields'] as $field) {
                $fieldList
                    ->add(new Field([
                        'id' => $field['id'],
                        'value' => $field['value'],
                    ]));
            }
            $contact->setFieldList($fieldList);
        }

        if (isset($contactFromResponse['groups'])) {
            $groupList = new GroupList();
            foreach ($contactFromResponse['groups'] as $group) {
                $groupList->add(new Group([
                    'id' => $group['id'],
                    'name' => $group['name'],
                    'type' => $group['type'],
                ]));
            }
            $contact->setGroupList($groupList);
        }

        if (isset($contactFromResponse['contactKey'])) {
            $contact->setContactKey($contactFromResponse['contactKey']);
        }

        if (isset($contactFromResponse['ordersInfo'])) {
            $contact->setOrdersInfo(new OrdersInfo([
                'lastDate' => $contactFromResponse['ordersInfo']['lastDate'],
                'count' => $contactFromResponse['ordersInfo']['count'],
            ]));
        }

        return $contact;
    }

    /**
     *  Add orders.
     *
     * @param OrderList $orderList
     *
     * @return bool
     */
    public function orders(OrderList $orderList)
    {
        $orderList->validate();

        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'orders',
                [$orderList->getKeyName() => $orderList->toArray()],
                HTTPClient::HTTP_METHOD_POST,
                true
            );

        if ('' == $response['response']) {
            return true;
        }

        return false;
    }
}
