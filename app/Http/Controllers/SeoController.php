<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $sitemap = rtrim((string) config('app.url'), '/').'/sitemap.xml';

        return response(
            "User-agent: *\nAllow: /\n\nSitemap: {$sitemap}\n",
            200,
        )->header('Content-Type', 'text/plain');
    }

    public function sitemap(): Response
    {
        $base = rtrim((string) config('app.url'), '/');
        $urls = [
            ['loc' => $base.'/', 'priority' => '1.0'],
            ['loc' => $base.'/nosotros', 'priority' => '0.8'],
            ['loc' => $base.'/productos', 'priority' => '0.8'],
            ['loc' => $base.'/encuentra-un-distribuidor', 'priority' => '0.7'],
            ['loc' => $base.'/inspirate', 'priority' => '0.7'],
            ['loc' => $base.'/hazlo-tu-mismo', 'priority' => '0.6'],
            ['loc' => $base.'/aviso-de-privacidad', 'priority' => '0.3'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>'.e($url['loc']).'</loc>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>'.$url['priority'].'</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
