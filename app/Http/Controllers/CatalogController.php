<?php

namespace App\Http\Controllers;

use App\Models\CatalogDownload;
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
}
