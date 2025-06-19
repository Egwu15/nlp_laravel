<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\LegalTerm;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class ImportLegalTerms extends Command
{
    protected $signature = 'legalterms:import {path : Path to JSON file}';
    protected $description = 'Import legal terms from a JSON file';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $path = $this->argument('path');

        if (!File::exists($path)) {
            $this->error("File not found: $path");
            return;
        }

        $json = File::get($path);
        $terms = json_decode($json, true);

        if (!is_array($terms)) {
            $this->error('Invalid JSON structure.');
            return;
        }

        $count = 0;

        foreach ($terms as $termData) {
            LegalTerm::create([
                'term' => $termData['term'] ?? null,
                'definition' => $termData['definition'] ?? null,
                'language' => $termData['language'] ?? null,
                'category' => $termData['category'] ?? null,
                'jurisdiction' => $termData['jurisdiction'] ?? null,
                'source' => $termData['source'] ?? null,
            ]);
            $count++;
        }

        $this->info("Imported $count legal terms successfully.");
    }
}
