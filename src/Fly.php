<?php

namespace M1guelpf\FlyAPI;

use GuzzleHttp\Client;

class Fly
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var string */
    protected $apiVersion;

    /**
     * @param \GuzzleHttp\Client $client
     * @param string             $apiToken
     * @param string             $apiVersion
     */
    public function __construct($apiToken = null, $apiVersion = 'v1')
    {
        $this->client = new Client();

        $this->apiToken = $apiToken;

        $this->baseUrl = 'https://fly.io/api/'.$apiVersion;
    }

    /**
     * @param string $apiToken
     *
     * @return string
     */
    public function connect($apiToken)
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \GuzzleHttp\Client $client
     *
     * @return void
     */
    public function setClient($client)
    {
        if ($client instanceof Client) {
            $this->client = $client;
        }

        return $this;
    }

    /**
     * @param string $slug
     *
     * @return array
     */
    public function getHostnames(string $slug)
    {
        return $this->get("sites/$slug/hostnames");
    }

    /**
     * @param string $slug
     * @param string $hostname
     *
     * @return array
     */
    public function createHostname(string $slug, string $hostname)
    {
        return $this->post("sites/$slug/hostnames", [
          'data' => [
            'attributes' => [
              'hostname'  => $hostname,
            ],
          ],
        ]);
    }

    /**
     * @param string $slug
     * @param string $hostname
     *
     * @return array
     */
    public function getHostname(string $slug, string $hostname)
    {
        return $this->get("sites/$slug/hostnames/$hostname");
    }

    /**
     * @param string $slug
     * @param string $name
     * @param string $type
     * @param array  $settings
     *
     * @return array
     */
    public function createBackend(string $slug, string $name, string $type, array $settings)
    {
        return $this->post("sites/$slug/hostnames", [
          'data' => [
            'attributes' => [
              'name'      => $name,
              'type'      => $type,
              'settings'  => $settings,
            ],
          ],
        ]);
    }

    /**
     * @param string  $slug
     * @param string  $hosname
     * @param string  $backend_id
     * @param string  $action_type
     * @param string  $path
     * @param integer $priority
     * @param string  $path_replacement
     *
     * @return array
     */
    public function createRule(string $slug, string $hostname, string $backend_id, string $action_type, string $path, int $priority = null, string $path_replacement = null)
    {
        return $this->post("sites/$slug/rules", [
          'data' => [
            'attributes' => [
              'hostname'          => $hostname,
              'backend_id'        => $backend_id,
              'action_type'       => $action_type,
              'path'              => $path,
              'priority'          => $priority,
              'path_replacement'  => $path_replacement,
            ],
          ],
        ]);
    }

    /**
     * @param string $resource
     * @param array  $query
     *
     * @return array
     */
    public function get($resource, array $query = [])
    {
      return $this->handleCall("GET", $resource, $query, []);
    }

    /**
     * @param string $resource
     * @param array  $rawdata
     *
     * @return array
     */
    public function post($resource, array $rawData = [])
    {
      return $this->handleCall("POST", $resource, [], $rawData);
    }

    /**
     * @param string $resource
     * @param array  $rawdata
     *
     * @return array
     */
    public function put($resource, array $rawData = [])
    {
        return $this->handleCall("PUT", $resource, [], $rawData);
    }

    /**
     * @param string $resource
     * @param array  $rawdata
     *
     * @return array
     */
    public function delete($resource, array $rawData = [])
    {
        return $this->handleCall("DELETE", $resource, [], $rawData);
    }

    /**
    * @param string $method HTTP method
    * @param string $resource Resource to invoke at Sqreen API
    * @param array  $query Request query string to pass in the URL
    * @param array  $rawData Request body
    *
    * @return array
    */
    protected function handleCall($method, $resource, array $query, array $rawData)
    {
      $data['headers'] = [
        'Authorization' => 'Bearer: '.$this->apiToken,
        'User-Agent' => 'php-fly-api'
      ];

      if(!empty($query)) {
        $data['query'] = $query;
      }

      if(!empty($rawData)) {
        $data['json'] = $rawdata;
      }

      $results = $this->client
      ->request($method, "{$this->baseUrl}/{$resource}", $data)
      ->getBody()
      ->getContents();

      return json_decode($results, true);
    }
}
