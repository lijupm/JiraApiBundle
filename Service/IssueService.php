<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Service class that deals with 'Issues' related JIRA apis.
 */
class IssueService extends AbstractService
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
     * Retrieve details for a specific issue.
     * 
     * @param string $key
     * 
     * @return array
     */
    public function getAll($key)
    {
        $url = $this->createUrl(sprintf('issue/%s', $key));

        $result = $this->getResponseAsArray($url);

        return $result;
    }
}
