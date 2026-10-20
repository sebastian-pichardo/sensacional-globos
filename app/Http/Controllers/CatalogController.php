<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeasonalCatalogRequest;
use App\Models\CatalogDownload;
use App\Models\ClientePotencial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CatalogController extends Controller
{
    public function download(Request $request): BinaryFileResponse|RedirectResponse
    {
        CatalogDownload::create([
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 512),
        ]);

        $path = public_path(config('globos.catalog_path'));

        if (is_file($path)) {
            return response()->download($path, 'catalogo-sensacional.pdf');
        }

        return back()->with(
            'catalog',
            'Catálogo próximamente. Mientras tanto, escríbenos y te lo enviamos. Envíos a todo México.',
        );
    }

    public function downloadRequested(StoreSeasonalCatalogRequest $request): BinaryFileResponse|RedirectResponse
    {
        $catalogo = $request->validated('catalogo');
        $esTemporada = $catalogo === 'temporada';

        ClientePotencial::query()->firstOrCreate(
            ['email' => $request->validated('email')],
            [
                'validado' => 'pendiente',
                'medio' => $esTemporada ? 'catalogo-temporada' : 'catalogo-general',
            ],
        );

        $path = public_path((string) config(
            $esTemporada ? 'globos.seasonal_catalog_path' : 'globos.catalog_path',
        ));
        $nombre = $esTemporada ? 'catalogo-de-temporada-2026.pdf' : 'catalogo-sensacional.pdf';

        if (is_file($path)) {
            return response()->download($path, $nombre);
        }

        return back()->withInput()->with(
            'seasonal_catalog',
            'El catálogo estará disponible en un momento. Mientras tanto, escríbenos y te lo enviamos.',
        );
    }
}
