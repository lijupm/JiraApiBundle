<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Base class that contain common features that is needed by other classes.
 */
abstract class AbstractService
{
    /**
     *
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * Constructor.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Creates and returns an stash compatible URL
     *
     * @param string $path
     * @param array  $params
     *
     * @return string
     */
    protected function createUrl($path, array $params = array())
    {
        $paramString = http_build_query($params);

        $url = sprintf('%s?%s', $path, $paramString);

        return $url;
    }

    /**
     * Get response as an array, returns false if no result.
     *
     * @param string $url
     *
     * @return array
     */
    protected function getResponseAsArray($url)
    {
        $request = $this->client->get($url);

        try  {
            $response = $request->send();
        } catch (BadResponseException $e) {
            return false;
        }

        $result = $response->json();

        if ($this->resultHasData($result)) {
            return $result;
        }

        return false;
    }

    /**
     * Set the result limit.
     *
     * @param integer $limit
     *
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Returns the size of the current result page.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Indicates whether the current page is the last result page.
     *
     * @return bool
     */
    public function isLastPage()
    {
        return $this->lastPage;
    }

    /**
     * Returns the start of the current result page.
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Indicates whether the current result page contains data.
     *
     * @param $result
     *
     * @return bool
     */
    private function resultHasData($result)
    {
        if (array_key_exists('errorMessages', $result)) {
            return false;
        }

        if (array_key_exists('errors', $result)) {
            return false;
        }

        if (0 === count($result)) {
            return false;
        }

        return true;
    }
}
