<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik;

use Brownie\ESputnik\HTTPClient\Curl as HTTPClient;
use Brownie\ESputnik\Model\Version;
use Brownie\ESputnik\Model\Subscribe;
use Brownie\ESputnik\Model\Contact;
use Brownie\ESputnik\Model\Group;
use Brownie\ESputnik\Model\GroupList;
use Brownie\ESputnik\Model\AddressBook;
use Brownie\ESputnik\Model\AddressBookFieldGroup;
use Brownie\ESputnik\Model\AddressBookField;

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
            ->request(HTTPClient::HTTP_CODE_200, 'version');

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
            ->request(HTTPClient::HTTP_CODE_200, 'contact/subscribe', $data, HTTPClient::HTTP_METHOD_POST);

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
            ->request(HTTPClient::HTTP_CODE_200, 'addressbooks');

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
            ->request(HTTPClient::HTTP_CODE_200, 'groups');

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
}
