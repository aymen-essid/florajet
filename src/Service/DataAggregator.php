<?php

namespace App\Service;

use App\Entity\Source;
use App\Interface\DataAggregatorInterface;
use App\Interface\FormatParserInterface;
use DOMDocument;

class DataAggregator implements DataAggregatorInterface {

    private $url;
    private $parser;

    public function __construct(string $url) {
        $this->url = $url;
    }

    public function setParser(FormatParserInterface $parser): void {
        $this->parser = $parser;
    }

    public function fetchData(): array {
        $response = file_get_contents($this->url);
        return $this->parser->parse($response);
    }

    public function aggregateData(): array {
        return $this->fetchData();
    }

    public function getPageTitle($url) {
        // Suppress warnings/errors due to malformed HTML
        libxml_use_internal_errors(true);
        
        // Fetch the HTML content from the URL
        $htmlContent = file_get_contents($url);
        
        // Create a new DOMDocument instance
        $dom = new DOMDocument();
        
        // Load the HTML into the DOMDocument object
        $dom->loadHTML($htmlContent);
        
        // Restore previous error handling
        libxml_use_internal_errors(false);
        
        // Extract the title tag content
        $titleNodes = $dom->getElementsByTagName('title');
        
        // Return the title or a default message if not found
        return $titleNodes->length > 0 ? $titleNodes->item(0)->nodeValue : 'No title found';
    }
}