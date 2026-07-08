<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

class NeodunkRenderer
{
    public function render(string $pageKey): array
    {
        $page = config("landing.pages.{$pageKey}");

        abort_unless($page, 404);

        $filePath = $this->templatePath("{$page['file']}.html");

        abort_unless(file_exists($filePath), 404, 'Template Neodunk não encontrado. Execute: php artisan basket:link-templates');

        $html = file_get_contents($filePath);
        $html = $this->rewriteAssets($html);
        $html = $this->rewriteLinks($html);
        $content = $this->extractMainContent($html);

        return [
            'content' => $content,
            'pageTitle' => $page['title'],
            'currentRoute' => $page['route'],
        ];
    }

    public function templatePath(string $file = ''): string
    {
        $base = rtrim(config('landing.assets.template_path'), DIRECTORY_SEPARATOR);

        return $file ? "{$base}/{$file}" : $base;
    }

    private function extractMainContent(string $html): string
    {
        if (preg_match('/<!-- Header End -->(.*?)<!-- Main Footer Start -->/s', $html, $matches)) {
            return trim($matches[1]);
        }

        if (preg_match('/<!-- Header End -->(.*?)<footer class="main-footer/s', $html, $matches)) {
            return trim($matches[1]);
        }

        return $html;
    }

    private function rewriteAssets(string $html): string
    {
        $baseUrl = rtrim(neodunk_asset(''), '/').'/';

        return preg_replace_callback(
            '/\b(href|src|data-src)=["\'](?!https?:\/\/|#|mailto:|javascript:|data:)([^"\']+)["\']/i',
            fn (array $matches) => $matches[1].'="'.$baseUrl.ltrim($matches[2], '/').'"',
            $html
        );
    }

    private function rewriteLinks(string $html): string
    {
        $map = config('landing.html_routes', []);

        foreach ($map as $htmlFile => $routeName) {
            if (! Route::has($routeName)) {
                continue;
            }

            $url = route($routeName);

            $html = str_replace('href="'.$htmlFile.'"', 'href="'.$url.'"', $html);
            $html = str_replace("href='{$htmlFile}'", "href='{$url}'", $html);
        }

        $html = str_replace(
            ['Neodunk - Basketball Club & Sports HTML Template', 'Welcome to Our Basketball Club'],
            [page_title(), config('landing.brand.tagline')],
            $html
        );

        return $html;
    }
}