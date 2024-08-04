<?php

namespace App\Interface;

use App\Entity\Source;

interface DataAggregatorInterface {
    
    public function setParser(FormatParserInterface $parser): void;
    public function fetchData(): array;
}