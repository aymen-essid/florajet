<?php

namespace App\Service\Parser;

use App\Interface\FormatParserInterface;

class XmlParser implements FormatParserInterface {
    
    public function parse($data): array {
        $xml = simplexml_load_string($data);
        $json = json_encode($xml);
        return json_decode($json, true);
    }
}