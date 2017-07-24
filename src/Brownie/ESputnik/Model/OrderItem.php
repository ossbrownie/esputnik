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
 * Order item.
 *
 * @method OrderItem    setExternalItemId($externalItemId)  Set ID of product in the external system (required).
 * @method OrderItem    setName($name)                      Set product name (required).
 * @method OrderItem    setCategory($category)              Set product category (required).
 * @method OrderItem    setQuantity($quantity)              Set number of items (required).
 * @method OrderItem    setCost($cost)                      Set product price (required).
 * @method OrderItem    setUrl($url)                        Set link to product page (required).
 * @method OrderItem    setImageUrl($imageUrl)              Set link to a product image.
 * @method OrderItem    setDescription($description)        Set short description of product.
 * @method string       getExternalItemId()                 Get ID of product in the external system.
 * @method string       getName()                           Get product name.
 * @method string       getCategory()                       Get product category.
 * @method int          getQuantity()                       Get number of items.
 * @method int          getCost()                           Get product price.
 * @method string       getUrl()                            Get link to product page.
 * @method string       getImageUrl()                       Get link to a product image.
 * @method string       getDescription()                    Get short description of product.
 */
class OrderItem extends ArrayList
{

    protected $fields = [
        'externalItemId' => null,
        'name' => null,
        'category' => null,
        'quantity' => null,
        'cost' => null,
        'url' => null,
        'imageUrl' => null,
        'description' => null
    ];

    /**
     * Validates the product.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        if (is_null($this->getName()) ||
            is_null($this->getCost()) ||
            is_null($this->getCategory()) ||
            is_null($this->getQuantity()) ||
            is_null($this->getExternalItemId())
        ) {
            throw new ValidateException('Blank Required Fields');
        }
    }
}
