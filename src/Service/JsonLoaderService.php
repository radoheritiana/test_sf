<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class JsonLoaderService
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function loadJson(string $filePath): array
    {
        $filesystem = new Filesystem();
        $fullPath = $this->projectDir . '/' . $filePath;

        if (!$filesystem->exists($fullPath)) {
            throw new FileNotFoundException("File not found: " . $fullPath);
        }

        $jsonData = file_get_contents($fullPath);

        return json_decode($jsonData, true);
    }
}