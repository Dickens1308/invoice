<?php

namespace App\Http\Controllers\services\mpesa\api;

use Exception;

class APIResponse
{

    var $status_code;
    var $headers;
    var $body;

    // Constructor

    /**
     * @throws Exception
     */
    function __construct($status_code, $headers, $body)
    {
        $this->set_status_code($status_code);
        $this->set_headers($headers);
        $this->set_body($body);
    }


    function get_status_code()
    {
        return $this->status_code;
    }

    /**
     * @throws Exception
     */
    function set_status_code($status_code): void
    {
        if (gettype($status_code) != 'integer') {
            throw new Exception('status_code must be a integer');
        } else {
            $this->status_code = $status_code;
        }
    }

    function get_headers()
    {
        return $this->headers;
    }

    /**
     * @throws Exception
     */
    function set_headers($headers): void
    {
        if (gettype($headers) != 'string') {
            throw new Exception('headers must be a string');
        } else {
            $this->headers = $headers;
        }
    }

    function get_body()
    {
        return $this->body;
    }

    /**
     * @throws Exception
     */
    function set_body($body): void
    {
        if (gettype($body) != 'string') {
            throw new Exception('body must be a string');
        } else {
            $this->body = $body;
        }
    }
}
