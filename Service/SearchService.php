<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Service class that handles searches.
 */
class SearchService extends AbstractService
{
    /**
     * @var int
     */
    private $start = 0;

    /**
     * @var int
     */
    private $limit = 50;

    /**
     * @var int
     */
    private $size = 0;

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
     * Search for issues.
     * 
     * @param array $params
     * 
     * @return boolean|array
     */
    public function getAll($params)
    {
        $url = $this->createUrl('search', $params);

        try {
            $result = $this->getResponseAsArray($url);
        } catch (BadResponseException $ex) {
            return false;
        }
        
        return $result;
    }

    public function createUrl($path, $params)
    {
        $params = array_merge(
            $params,
            array(
                'startAt'    => $this->start,
                'maxResults' => $this->limit
            )
        );

        $url = parent::createUrl($path, $params);

        $this->start = 0;
        $this->limit = 0;

        return $url;
    }

    public function getResponseAsArray($url)
    {
        $result = parent::getResponseAsArray($url);

        if ($result) {
            $this->start = $result['startAt'];
            $this->limit = $result['maxResults'];
            $this->size  = $result['total'];

            if (!$this->lastPage) {
                $this->start += $this->limit;
            }
        }

        return $result;
    }
}
