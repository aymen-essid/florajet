<?php

namespace App\Service\Source;

use App\Entity\Source;
use App\Interface\DataSourceInterface;
use App\Interface\FormatParserInterface;

class ApiSource implements DataSourceInterface {
    
    private $apiUrl;
    private $parser;

    public function __construct(string $apiUrl) {
        $this->apiUrl = $apiUrl;
    }

    public function setParser(FormatParserInterface $parser): void {
        $this->parser = $parser;
    }

    public function fetchData(): array {
        $response = file_get_contents($this->apiUrl);
        return $this->parser->parse($response);
    }

    public function map(array $sourceData, Source $source): array {
        return [
            'name' => $sourceData['title'],
            'content' => $sourceData['description'],
            'sourceId' =>$source
        ];
    }
}