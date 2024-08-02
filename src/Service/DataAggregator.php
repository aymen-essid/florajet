<?php

namespace App\Service;

use App\Interface\DataSourceInterface;

class DataAggregator {
    
    private $sources = [];

    public function addSource(DataSourceInterface $source): void {
        $this->sources[] = $source;
    }

    public function aggregateData(): array {
        $aggregatedData = [];
        foreach ($this->sources as $source) {
            $data = $source->fetchData();
            $aggregatedData = array_merge($aggregatedData, $data);
        }
        return $aggregatedData;
    }
}