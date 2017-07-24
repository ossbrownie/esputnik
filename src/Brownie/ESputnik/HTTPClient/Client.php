<?php
/**
 * @category    Brownie/ESputnik
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */
namespace Brownie\ESputnik\HTTPClient;

interface Client
{

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
    public function httpRequest(
        $apiUrl,
        $userPwd,
        $data,
        $method,
        $timeOut
    );
}
