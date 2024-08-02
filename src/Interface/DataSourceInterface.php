<?php

namespace App\Interface;

use App\Entity\Source;

interface DataSourceInterface {
    
    public function setParser(FormatParserInterface $parser): void;
    public function map(array $sourceData, Source $source): array;
    public function fetchData(): array;
}