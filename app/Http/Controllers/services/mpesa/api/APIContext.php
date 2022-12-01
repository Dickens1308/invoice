<?php

namespace App\Http\Controllers\services\mpesa\api\api\api\api;


use App\Http\Controllers\services\mpesa\api\api\api\APIMethodType;
use Exception;


class APIContext
{


    var string $api_key = '';
    var string $public_key = '';
    var bool $ssl = false;
    var int $method_type = APIMethodType::GET;
    var string $address = '';
    var int $port = 80;
    var string $path = '';
    var array $headers = array();
    var array $parameters = array();


    // Constructor with optional prepopulated variables

    /**
     * @throws Exception
     */
    public function __construct($dictionary = null)
    {
        if ($dictionary != null && gettype($dictionary) != 'array') {
            throw new Exception('Input must be an array');
        }

        if ($dictionary != null) {
            foreach ($dictionary as $i => $item) {
                switch (strtolower($i)) {
                    case 'api_key':
                        $this->set_api_key($dictionary[$i]);
                        break;
                    case 'public_key':
                        $this->set_public_key($dictionary[$i]);
                        break;
                    case 'ssl':
                        $this->set_ssl($dictionary[$i]);
                        break;
                    case 'method_type':
                        $this->set_method_type($dictionary[$i]);
                        break;
                    case 'address':
                        $this->set_address($dictionary[$i]);
                        break;
                    case 'port':
                        $this->set_port($dictionary[$i]);
                        break;
                    case 'path':
                        $this->set_path($dictionary[$i]);
                        break;
                    case 'headers':
                        if (gettype($dictionary[$i]) != 'array') {
                            throw new Exception('headers must be an array');
                        }
                        foreach ($dictionary[$i] as $key => $value) {
                            $this->add_header($key, $dictionary[$i][$key]);
                        }
                        break;
                    case 'parameters':
                        if (gettype($dictionary[$i]) != 'array') {
                            throw new Exception('parameters must be an array');
                        }
                        foreach ($dictionary[$i] as $key => $value) {
                            $this->add_parameter($key, $dictionary[$i][$key]);
                        }
                        break;
                    default:
                        echo 'Unknown parameter type';
                }
            }
        }
    }

    // Build the URL from context parameters

    function add_header($header, $value): void
    {
        $this->headers[$header] = $value;
    }

    // Add/update headers

    function add_parameter($key, $value): void
    {
        $this->parameters[$key] = $value;
    }

    // Get headers as an array

    function get_url(): string
    {
        return 'https://' . $this->address . ':' . $this->port . $this->path;
    }

    // Add parameter

    function get_headers(): array
    {
        $headers = array();
        foreach ($this->headers as $key => $value) {
            $headers[] = $key . ": " . $value;
        }

        return $headers;
    }

    // Get parameters

    function get_parameters(): array
    {
        return $this->parameters;
    }

    function get_api_key(): string
    {
        return $this->api_key;
    }

    /**
     * @throws Exception
     */
    function set_api_key($api_key): void
    {
        if (gettype($api_key) != 'string') {
            throw new Exception('api_key must be a string');
        } else {
            $this->api_key = $api_key;
        }
    }

    function get_public_key(): string
    {
        return $this->public_key;
    }

    /**
     * @throws Exception
     */
    function set_public_key($public_key): void
    {
        if (gettype($public_key) != 'string') {
            throw new Exception('public_key must be a string');
        } else {
            $this->public_key = $public_key;
        }
    }

    function get_ssl(): bool
    {
        return $this->ssl;
    }

    function set_ssl($ssl): void
    {
        if (gettype($ssl) != 'boolean') {
            throw new Exception('ssl must be a boolean');
        } else {
            $this->ssl = $ssl;
        }
    }

    function get_method_type(): int
    {
        return $this->method_type;
    }

    /**
     * @throws Exception
     */
    function set_method_type($method_type): void
    {
        if (gettype($method_type) != 'integer') {
            throw new Exception('method_type must be a integer');
        } else {
            $this->method_type = $method_type;
        }
    }

    function get_address(): string
    {
        return $this->address;
    }

    /**
     * @throws Exception
     */
    function set_address($address): void
    {
        if (gettype($address) != 'string') {
            throw new Exception('address must be a string');
        } else {
            $this->address = $address;
        }
    }

    function get_port(): int
    {
        return $this->port;
    }

    /**
     * @throws Exception
     */
    function set_port($port): void
    {
        if ($port != null && gettype($port) != 'integer') {
            throw new Exception('port must be a integer');
        } else {
            $this->port = $port;
        }
    }

    function get_path(): string
    {
        return $this->path;
    }

    /**
     * @throws Exception
     */
    function set_path($path): void
    {
        if (gettype($path) != 'string') {
            throw new Exception('path must be a string');
        } else {
            $this->path = $path;
        }
    }

}
