<?php

namespace App\Service\Import;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CsvService
{
    public function import($filename, $options = []): array
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        return $serializer->decode(file_get_contents($filename), CsvEncoder::FORMAT, $options);
    }
}
