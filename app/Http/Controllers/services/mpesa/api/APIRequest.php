<?php

namespace App\Http\Controllers\services\mpesa\api\api;

use App\Http\Controllers\services\mpesa\api\api\api\APIMethodType;
use App\Http\Controllers\services\mpesa\api\APIResponse;
use App\Http\Controllers\services\mpesa\Crypt\RSA;
use Exception;

class APIRequest
{

    protected $context;

    // Constructor context

    /**
     * @throws Exception
     */
    function __construct($context)
    {

        $this->context = $context;
    }

    // Does the HTTP Request

    /**
     * @throws Exception
     */
    function execute(): ?APIResponse
    {
        if ($this->context == null) {
            throw new Exception('Context cannot be null');
        }
        $this->create_default_headers();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        return match ($this->context->get_method_type()) {
            APIMethodType::GET => $this->__get($ch),
            APIMethodType::POST => $this->__post($ch),
            APIMethodType::PUT => $this->__put($ch),
            default => null,
        };
    }

    // Creates the Authorisation bearer token using the RSA public key provided

    function create_default_headers(): void
    {
        $this->context->add_header('Authorization', 'Bearer ' . $this->create_bearer_token());
        $this->context->add_header('Content-Type', 'application/json');
        $this->context->add_header('Host', $this->context->get_address());
    }

    // Add the default headers

    function create_bearer_token(): string
    {
        // Need to do these lines to create a 'valid' formatted RSA key for the openssl library
        $rsa = new RSA();
        $rsa->loadKey($this->context->get_public_key());
        $rsa->setPublicKey($this->context->get_public_key());

        $publickey = $rsa->getPublicKey();
        $api_encrypted = '';
        $encrypted = '';

        if (openssl_public_encrypt($this->context->get_api_key(), $encrypted, $publickey)) {
            $api_encrypted = base64_encode($encrypted);
        }
        return $api_encrypted;
    }

    // Do a GET request

    function __get($ch)
    {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_URL, $this->context->get_url() . '?' . http_build_query($this->context->get_parameters()));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->context->get_headers());
        $response = curl_exec($ch);

        // echo $response;
        // echo '<br>';
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        curl_close($ch);
        return new APIResponse($status_code, $headers, $body);
    }

    // Do a POST request
    function __post($ch): APIResponse
    {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $this->context->get_url());
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->context->get_headers());
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->context->get_parameters()));
        $response = curl_exec($ch);
        // echo $response;
        // echo '<br>';
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        curl_close($ch);
        return new APIResponse($status_code, $headers, $body);
    }

    // Do a PUT request
    function __put($ch): APIResponse
    {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_URL, $this->context->get_url());
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->context->get_headers());
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->context->get_parameters()));
        $response = curl_exec($ch);
        // echo $response;
        // echo '<br>';
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        curl_close($ch);
        return new APIResponse($status_code, $headers, $body);

    }

    /**
     * @throws Exception
     */
    function __unknown()
    {
        throw new Exception('Unknown method');
    }
}

// API Response

// Api Method Type Constants

// API Context that contain info for the API endpoint


