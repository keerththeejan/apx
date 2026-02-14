<?php

namespace App\Console\Commands;

use App\Models\FooterLink;
use App\Models\NavLink;
use Illuminate\Console\Command;

class FixLocalhostUrls extends Command
{
    protected $signature = 'fix:localhost-urls';
    protected $description = 'Replace localhost URLs in nav_links and footer_links with relative paths for production';

    public function handle(): int
    {
        $fixed = 0;

        foreach (NavLink::all() as $link) {
            $url = $link->url;
            if ($url && $this->isLocalhostUrl($url)) {
                $link->url = $this->toRelativePath($url);
                $link->save();
                $this->info("Nav: {$link->label} -> {$link->url}");
                $fixed++;
            }
        }

        if (class_exists(FooterLink::class)) {
            foreach (FooterLink::all() as $link) {
                $url = $link->url;
                if ($url && $this->isLocalhostUrl($url)) {
                    $link->url = $this->toRelativePath($url);
                    $link->save();
                    $this->info("Footer: {$link->label} -> {$link->url}");
                    $fixed++;
                }
            }
        }

        $this->info("Fixed {$fixed} URLs.");
        return 0;
    }

    private function isLocalhostUrl(string $url): bool
    {
        $host = parse_url($url, PHP_URL_HOST);
        return $host && in_array(strtolower($host), ['localhost', '127.0.0.1'], true);
    }

    private function toRelativePath(string $url): string
    {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '/';
        $path = preg_replace('#^/apx(/|$)#', '$1', $path) ?: '/';
        $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
        return $path . $query;
    }
}
