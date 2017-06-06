<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */
namespace Brownie\ESputnik\HTTPClient;

use Brownie\ESputnik\Exception\InvalidCode as InvalidCodeException;
use Brownie\ESputnik\Exception\Json as JsonException;
use Brownie\ESputnik\Config;

abstract class HTTPClient
{
    const HTTP_METHOD_GET = 'GET';

    const HTTP_METHOD_POST = 'POST';

    const HTTP_METHOD_PUT = 'PUT';

    const HTTP_METHOD_DELETE = 'DELETE';

    const HTTP_CODE_200 = 200;

    /**
     * ESputnik configuration.
     * @var Config
     */
    private $config;

    /**
     * Sets incoming data.
     *
     * @param Config    $config     ESputnik configuration.
     */
    public function __construct(Config $config)
    {
        $this->setConfig($config);
    }

    /**
     * Sets the ESputnik configuration.
     * Returns the current object.
     *
     * @param Config    $config     ESputnik configuration.
     *
     * @return self
     */
    private function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Returns ESputnik configuration.
     *
     * @return Config
     */
    private function getConfig()
    {
        return $this->config;
    }

    /**
     * Performs a network request in ESputnik.
     * Returns the response from ESputnik.
     *
     * @param int       $checkHTTPCode          Checked HTTP Code
     * @param string    $endpoint               The access endpoint to the resource.
     * @param array     $data                   An array of data to send.
     * @param string    $method                 Query Method.
     * @param boolean   $ignoreEmptyResponse    Semaphore of ignoring an empty response.
     *
     * @throws InvalidCodeException
     * @throws JsonException
     *
     * @return array
     */
    public function request(
        $checkHTTPCode,
        $endpoint,
        $data = [],
        $method = self::HTTP_METHOD_GET,
        $ignoreEmptyResponse = false
    ) {
        /**
         * Creates a complete URL to the resource.
         */
        $apiUrl = implode(
            '/',
            [
                $this->getConfig()->getApiUrl(),
                $this->getConfig()->getProtocolVersion(),
                $endpoint
            ]
        );

        if (is_object($data)) {
            $data = $data->toArray();
        }

        list($responseBody, $httpCode, $runtime) = $this->httpRequest(
            $apiUrl,
            $this->getConfig()->getUserPwd(),
            $data,
            $method,
            $this->getConfig()->getTimeOut()
        );

        /**
         * Checking HTTP Code.
         */
        if ($checkHTTPCode != $httpCode) {
            throw new InvalidCodeException($httpCode);
        }

        if ($ignoreEmptyResponse && empty($response)) {
            $response = [];
        } else {
            $response = json_decode($responseBody, true);

            /**
             * Parse Json checking.
             */
            if (json_last_error() != JSON_ERROR_NONE) {
                throw new JsonException(json_last_error_msg());
            }
        }

        return [
            'httpCode' => $httpCode,
            'response' => $response,
            'runtime' => $runtime
        ];
    }

    /**
     * Performs a network request.
     *
     * @param string    $apiUrl
     * @param string    $userPwd
     * @param array     $data
     * @param string    $method
     * @param int       $timeOut
     *
     * @return mixed
     */
    abstract protected function httpRequest(
        $apiUrl,
        $userPwd,
        $data,
        $method,
        $timeOut
    );
}
