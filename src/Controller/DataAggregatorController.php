<?php

namespace App\Controller;

use App\Service\DataAggregator;
use App\Service\Parser\JsonParser;
use App\Service\Source\ApiSource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DataAggregatorController extends AbstractController
{
    #[Route('/data/aggregator', name: 'app_data_aggregator')]
    public function index(): JsonResponse
    {

        // Create format parsers
        $jsonParser = new JsonParser();

        // Create data sources
        $apiSource = new ApiSource('https://saurav.tech/NewsAPI/top-headlines/category/health/fr.json');
        $apiSource->setParser($jsonParser);

        // Create and use aggregator
        $aggregator = new DataAggregator();
        $aggregator->addSource($apiSource);

        $aggregatedData = $aggregator->aggregateData();


        return $this->json([
            'data' => $aggregatedData,
        ]);
    }
}
