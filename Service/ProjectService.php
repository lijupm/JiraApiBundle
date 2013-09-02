<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Service class that handles projects.
 */
class ProjectService extends AbstractService
{
    /**
     * Constructor.
     *
     * @param \Guzzle\Http\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Method to retrieve all projects.
     * 
     * @return boolean|array
     */
    public function getAll()
    {
        $url = $this->createUrl('project');

        try {
            $data = $this->getResponseAsArray($url);
        } catch (BadResponseException $ex) {
            return false;
        }

        return $data;
    }
}
