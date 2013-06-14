<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
/**
 * Service class that deals with 'Search' related JIRA apis.
 */
class SearchService extends AbstractService
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
     * @return boolean|array
     */
    public function search($params)
    {
        $path = 'search';
        $url = $this->createUrl($path, $params);
        try {
            $issueDetail = $this->getResponseAsArray($url);
        } catch (BadResponseException $ex) {
            return false;
        }
        
        return $issueDetail;
    }
}
