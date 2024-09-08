<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class HttpService
{
    protected $client;

    public function __construct(array $config = [])
    {
        $this->client = new Client(array_merge([
            'timeout'  => 2,
            'debug'    => true,
            'verify'    => false,
        ], $config));
    }


    /**
     * Make a GET request.
     *
     * @param string $url
     * @param array $query
     * @return array
     */
    public function get(string $url, array $query = []): array
    {
        return $this->request('GET', $url, ['query' => $query]);
    }

    /**
     * Make a POST request.
     *
     * @param string $url
     * @param array $data
     * @return array
     */
    public function post(string $url, array $data = []): array
    {
        return $this->request('POST', $url, ['form_params' => $data]);
    }

    /**
     * Make a request.
     *
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     */
    protected function request(string $method, string $url, array $options = []): array
    {
        try {
            $response = $this->client->request($method, $url, $options);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Handle a successful response.
     *
     * @param ResponseInterface $response
     * @return array
     */
    protected function handleResponse(ResponseInterface $response): array
    {
        return [
            'status_code' => $response->getStatusCode(),
            'body' => json_decode($response->getBody()->getContents(), true),
            'headers' => $response->getHeaders(),
        ];
    }

    /**
     * Handle an error response.
     *
     * @param RequestException $exception
     * @return array
     */
    protected function handleError(RequestException $exception): array
    {
        return [
            'status_code' => $exception->hasResponse()
                ? $exception->getResponse()->getStatusCode()
                : 500,
            'error' => $exception->getMessage(),
            'body' => $exception->hasResponse()
                ? json_decode($exception->getResponse()->getBody()->getContents(), true)
                : null,
        ];
    }
}
