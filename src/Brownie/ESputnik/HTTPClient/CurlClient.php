<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\ESputnik\HTTPClient\Curl;

use Brownie\ESputnik\Exception\ClientException;
use Brownie\ESputnik\HTTPClient\HTTPClient;

/**
 * HTTP client based on cURL.
 */
class CurlClient extends HTTPClient
{

    /**
     * Performs a network request in ESputnik.
     * Returns the response from ESputnik.
     *
     * @param string    $apiUrl
     * @param string    $userPwd
     * @param array     $data
     * @param string    $method
     * @param int       $timeOut
     *
     * @throws ClientException
     *
     * @return array
     */
    protected function httpRequest(
        $apiUrl,
        $userPwd,
        $data,
        $method,
        $timeOut
    ) {
        /**
         * Executes a network resource request.
         */
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeOut);
        curl_setopt($curl, CURLOPT_NOPROGRESS, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Connection: close',
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8'
        ]);
        curl_setopt($curl, CURLOPT_USERPWD, $userPwd);
        $responseBody = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        /**
         * Network error checking.
         */
        if ((0 != curl_errno($curl)) || !is_string($responseBody)) {
            throw new ClientException(curl_error($curl));
        }

        $runtime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);

        curl_close($curl);

        return [
            $responseBody,
            $httpCode,
            $runtime
        ];
    }
}
