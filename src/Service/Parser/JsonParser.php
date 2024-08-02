<?php

namespace App\Service\Parser;

use App\Interface\FormatParserInterface;

class JsonParser implements FormatParserInterface {

    public function parse($data): array {
        return json_decode($data, true);
    }
}