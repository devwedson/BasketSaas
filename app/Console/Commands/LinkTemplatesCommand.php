<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LinkTemplatesCommand extends Command
{
    protected $signature = 'basket:link-templates';

    protected $description = 'Cria links simbólicos dos templates neodunk e attex em public/';

    public function handle(): int
    {
        $links = [
            public_path('neodunk') => base_path('neodunk'),
            public_path('attex') => base_path('attex/tailwind/layouts'),
        ];

        foreach ($links as $link => $target) {
            if (! is_dir($target)) {
                $this->error("Pasta não encontrada: {$target}");

                continue;
            }

            if (file_exists($link)) {
                $this->line("Já existe: {$link}");
                continue;
            }

            if (PHP_OS_FAMILY === 'Windows') {
                exec('cmd /c mklink /J "'.str_replace('/', '\\', $link).'" "'.str_replace('/', '\\', $target).'"', $output, $code);

                if ($code !== 0) {
                    $this->error("Falha ao criar junction: {$link}");

                    continue;
                }
            } elseif (! symlink($target, $link)) {
                $this->error("Falha ao criar symlink: {$link}");

                continue;
            }

            $this->info("Link criado: {$link} -> {$target}");
        }

        return self::SUCCESS;
    }
}