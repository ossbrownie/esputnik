<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\HTTPClient;

use Brownie\ESputnik\Config;
use Brownie\ESputnik\Exception\Curl as CurlException;
use Brownie\ESputnik\Exception\Json as JsonException;
use Brownie\ESputnik\Exception\InvalidCode as InvalidCodeException;

/**
 * HTTP client based on cURL.
 */
class Curl
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
     * @param int    $checkHTTPCode Checked HTTP Code
     * @param string $endpoint      The access endpoint to the resource.
     * @param array  $data          An array of data to send.
     * @param string $method        Query Method.
     *
     * @throws CurlException
     * @throws InvalidCodeException
     * @throws JsonException
     *
     * @return array
     */
    public function request($checkHTTPCode, $endpoint, $data = [], $method = self::HTTP_METHOD_GET)
    {
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

        if (!is_array($data)) {
            $data = $data->toArray();
        }

        /**
         * Executes a network resource request.
         */
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->getConfig()->getTimeOut());
        curl_setopt($curl, CURLOPT_NOPROGRESS, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Connection: close',
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8'
        ]);
        curl_setopt($curl, CURLOPT_USERPWD, $this->getConfig()->getUserPwd());
        $responseBody = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        /**
         * Checking HTTP Code.
         */
        if ($checkHTTPCode != $httpCode) {
            throw new InvalidCodeException($httpCode);
        }

        /**
         * Network error checking.
         */
        if ((0 != curl_errno($curl)) || !is_string($responseBody)) {
            throw new CurlException(curl_error($curl));
        }

        $response = json_decode($responseBody, true);

        /**
         * Parse Json checking.
         */
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new JsonException(json_last_error_msg());
        }

        $runtime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);

        curl_close($curl);

        return [
            'httpCode' => $httpCode,
            'response' => $response,
            'runtime' => $runtime
        ];
    }
}
