<?php

namespace App\Service\Parser;

use App\Interface\FormatParserInterface;

class CsvParser implements FormatParserInterface {
    
    public function parse($data): array {
        $rows = explode(PHP_EOL, $data);
        $header = str_getcsv(array_shift($rows));
        $parsedData = [];

        foreach ($rows as $row) {
            if (!empty(trim($row))) {
                $parsedData[] = array_combine($header, str_getcsv($row));
            }
        }

        return $parsedData;
    }
}