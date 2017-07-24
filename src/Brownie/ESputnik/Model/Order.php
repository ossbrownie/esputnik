<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\Model;

use Brownie\ESputnik\Model\Base\ArrayList;
use Brownie\ESputnik\Exception\ValidateException;

/**
 * Order.
 *
 * @method Order   setStatus($status)                           Set order status (required).
 * @method Order   setExternalOrderId($externalOrderId)         Set ID of order in the external system (required).
 * @method Order   setExternalCustomerId($externalCustomerId)   Set ID of customer in the external system (required).
 * @method Order   setTotalCost($totalCost)                     Set total cost of order (required).
 * @method Order   setEmail($email)                             Set customer email address.
 * @method Order   setPhone($phone)                             Set customer phone number.
 * @method Order   setFirstName($firstName)                     Set Customer first name.
 * @method Order   setLastName($lastName)                       Set customer last name.
 * @method Order   setStoreId($storeId)                         Set store ID (if you work with several stores in one eSputnik account).
 * @method Order   setShipping($shipping)                       Set shipping cost.
 * @method Order   setDeliveryMethod($deliveryMethod)           Set delivery method.
 * @method Order   setDeliveryAddress($deliveryAddress)         Set delivery address.
 * @method Order   setTaxes($taxes)                             Set amount of tax.
 * @method Order   setPaymentMethod($paymentMethod)             Set payment method.
 * @method Order   setDiscount($discount)                       Set discount.
 * @method Order   setRestoreUrl($restoreUrl)                   Set link to order.
 * @method Order   setStatusDescription($statusDescription)     Set order status description.
 * @method Order   setCurrency($currency)                       Set currency according to ISO 4217.
 * @method Order   setSource($source)                           Set source.
 */
class Order extends ArrayList
{

    const STATUS_INITIALIZED = 'INITIALIZED';

    const STATUS_IN_PROGRESS = 'IN_PROGRESS';

    const STATUS_CANCELLED = 'CANCELLED';

    const STATUS_DELIVERED = 'DELIVERED';

    const STATUS_ABANDONED_SHOPPING_CART = 'ABANDONED_SHOPPING_CART';

    protected $fields = [
        'status' => null,
        'date' => null,
        'externalOrderId' => null,
        'externalCustomerId' => null,
        'totalCost' => null,
        'email' => null,
        'phone' => null,
        'firstName' => null,
        'lastName' => null,
        'storeId' => null,
        'shipping' => null,
        'deliveryMethod' => null,
        'deliveryAddress' => null,
        'taxes' => null,
        'paymentMethod' => null,
        'discount' => null,
        'restoreUrl' => null,
        'statusDescription' => null,
        'currency' => null,
        'source' => null,
        'items' => null,
    ];

    /**
     * Set order date and time (required).
     *
     * @param string    $date   Date (For example "2017-05-14T10:11:10.7022176+03:00")
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->fields['date'] = date('Y-m-d\TH:m:s', strtotime($date));
        return $this;
    }

    /**
     * Add product info.
     *
     * @param OrderItem $orderItem  Product info.
     *
     * @return self
     */
    public function addItem(OrderItem $orderItem)
    {
        if (is_null($this->getItems())) {
            $this->setItems(new OrderItemList());
        }
        $this->getItems()->add($orderItem);
        return $this;
    }

    public function toArray()
    {
        return array_map(
            function ($field) {
                if (is_object($field)) {
                    return $field->toArray();
                }
                return $field;
            }, parent::toArray()
        );
    }

    /**
     * Validates the order.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        if (is_null($this->getStatus()) ||
            is_null($this->getDate()) ||
            is_null($this->getExternalOrderId()) ||
            is_null($this->getExternalCustomerId()) ||
            is_null($this->getTotalCost()) ||
            is_null($this->getItems()) ||
            empty($this->getItems())
        ) {
            throw new ValidateException('Blank Required Fields');
        }
        foreach ($this->getItems() as $orderItem) {
            $orderItem->validate();
        }
    }
}
