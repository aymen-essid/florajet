<?php

namespace App\Interface;

interface FormatParserInterface {

    public function parse($data): array;
}