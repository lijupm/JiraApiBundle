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
     * @param Guzzle\Http\Client $client 
     */
    public function __construct(Client $client)
    {
        $this->client = $client;        
    }

    /**
     * Method to get issue details from JIRA.
     * 
     * @param string $issueId Issue ID holds the pattern DDI-111
     * 
     * @return array
     */
    public function getIssueDetails($issueId)
    {
        $path = sprintf('issue/%s', $issueId);
        $url = $this->createUrl($path);
        $issueDetail = $this->getResponseAsArray($url);
        
        return $issueDetail;
    }
}
