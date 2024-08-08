<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\DataAggregator;
use App\Service\Parser\JsonParser;
use App\Service\Parser\XmlParser;
use App\Service\Source\ApiSource;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DataAggregatorController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $em) : Response
    {
        
        $repository = $em->getRepository(Article::class);
        $articles = $repository->findAll();

        return $this->render('articles.html.twig', [
            'articles' => $articles
        ]);
    }


    #[Route('/data/aggregator/source1', name: 'app_source1_aggregator')]
    public function source1(EntityManagerInterface $em): JsonResponse
    {

        // Create aggregator
        $aggregator = new DataAggregator($this->getParameter('app.source_1'));

        // Create format parsers
        $jsonParser = new JsonParser();
        $aggregator->setParser($jsonParser);

        $aggregatedData = $aggregator->aggregateData();
        $artilcles = $aggregatedData['articles'];

        // Save Articles to database
        foreach($artilcles as $item){
            $artilcle = new Article();
            $artilcle->setTitle($item['title']);
            $artilcle->setContent($item['content']);
            $em->persist($artilcle);
        }
        $em->flush();

        return $this->json([
            'data' => $artilcles,
        ]);
    }

    #[Route('/data/aggregator/source2', name: 'app_source2_aggregator')]
    public function source2(EntityManagerInterface $em): JsonResponse
    {

        // Create aggregator
        $aggregator = new DataAggregator($this->getParameter('app.source_2'));

        // Create format parsers
        $jsonParser = new JsonParser();
        $aggregator->setParser($jsonParser);

        $aggregatedData = $aggregator->aggregateData();
        $artilcles = $aggregatedData['articles'];

        // Save Articles to database
        foreach($artilcles as $item){
            $artilcle = new Article();
            $artilcle->setTitle($item['title']);
            $artilcle->setContent(($item['content'] != null) ? $item['content'] : $item['url']);
            $em->persist($artilcle);
        }
        $em->flush();

        return $this->json([
            'data' => $artilcles,
        ]);
    }

    #[Route('/data/aggregator/source4', name: 'app_source4_aggregator')]
    public function source4(EntityManagerInterface $em): JsonResponse
    {

        // Create format parsers
        $xmlParser = new XmlParser();

        // Create and use aggregator
        $aggregator = new DataAggregator($this->getParameter('app.source_4'));
        $aggregator->setParser($xmlParser);

        $aggregatedData = $aggregator->aggregateData();
        $artilcles = $aggregatedData['channel']['item'];

        // Save Articles to database
        foreach($artilcles as $item){
            $artilcle = new Article();
            $artilcle->setTitle(htmlentities($aggregator->getPageTitle($item['link'])));
            $artilcle->setContent($item['link']);
            $em->persist($artilcle);
        }
        $em->flush();

        return $this->json([
            'data' => $artilcles,
        ]);
    }
}
