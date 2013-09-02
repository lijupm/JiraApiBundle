<?php

namespace JiraApiBundle\Tests\Service;

use JiraApiBundle\Tests\TestCase;
use JiraApiBundle\Service\SearchService;

class SearchServiceTest extends TestCase
{
    public function testSearchServiceGetAll()
    {        
        $jsonFile = __DIR__ . '/../assets/response/search.json';

        $service = new SearchService(
            $this->getClientMock($jsonFile)
        );

        $params = array(
            'jql' => 'id=TD-945'
        );

        $result = $service->getAll($params);

        $this->assertEquals('TD-945', $result['issues'][0]['key']);
        $this->assertEquals('Bug', $result['issues'][0]['fields']['issuetype']['name']);
    }

    public function testSearchServiceGetAllException()
    {
        $service = new SearchService($this->getClientMockException());

        $result = $service->getAll(array());

        $this->assertEquals(false, $result);
    }

    public function testSearchServiceGetAllNoData()
    {
        $service = new SearchService($this->getClientMockNoData());

        $result = $service->getAll(array());

        $this->assertEquals(false, $result);
    }
}
