<?php

namespace App\Support;

class AttexTemplate
{
    public function authBackground(): string
    {
        $file = rtrim(config('attex.assets.template_path'), DIRECTORY_SEPARATOR).'/auth-login.html';

        if (! file_exists($file)) {
            return view('partials.attex.auth-background')->render();
        }

        $html = file_get_contents($file);

        if (preg_match('/<!-- Svg Background -->(.*?)<!-- Login Card -->/s', $html, $matches)) {
            return $this->rewriteAttexAssets(trim($matches[1]));
        }

        return view('partials.attex.auth-background')->render();
    }

    private function rewriteAttexAssets(string $html): string
    {
        $baseUrl = rtrim(attex_asset(''), '/').'/';

        return preg_replace_callback(
            '/\b(href|src|xlink:href)=["\'](?!https?:\/\/|#|mailto:|javascript:|data:)([^"\']+)["\']/i',
            fn (array $matches) => $matches[1].'="'.$baseUrl.ltrim($matches[2], '/').'"',
            $html
        );
    }
}