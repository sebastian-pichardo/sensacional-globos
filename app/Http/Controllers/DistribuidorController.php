<?php

namespace App\Http\Controllers;

use App\Models\Distribuidor;
use App\Models\Estado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DistribuidorController extends Controller
{
    public function index(): Response
    {
        $estados = Estado::query()
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get(['nombre', 'clave_sat', 'abrev']);

        $distribuidores = Distribuidor::query()
            ->with('estado:id,nombre,clave_sat')
            ->where('activo', 'si')
            ->orderBy('empresa')
            ->get()
            ->map(fn (Distribuidor $distribuidor) => [
                'id' => $distribuidor->id,
                'empresa' => $distribuidor->empresa,
                'direccion' => $distribuidor->direccion(),
                'telefono' => $distribuidor->telefono,
                'whatsapp' => $distribuidor->whatsapp,
                'estado_clave' => $distribuidor->estado_clave,
                'estado' => $distribuidor->estado?->nombre,
                'latitude' => $distribuidor->tieneUbicacion() ? $distribuidor->latitude : null,
                'longitude' => $distribuidor->tieneUbicacion() ? $distribuidor->longitude : null,
            ]);

        return Inertia::render('EncuentraDistribuidor', [
            'estados' => $estados,
            'distribuidores' => $distribuidores,
            'states' => config('globos.states'),
            'catalogHint' => config('globos.distributor_catalog_hint'),
        ]);
    }

    public function downloadCatalog(Request $request): BinaryFileResponse|RedirectResponse
    {
        $hint = (string) config('globos.distributor_catalog_hint');
        $clave = trim((string) $request->input('clave', ''));

        if (! Distribuidor::claveEsValida($clave)) {
            return back()->with('catalog_error', $hint);
        }

        $path = public_path((string) config('globos.distributor_catalog_path'));

        if (! is_file($path)) {
            return back()->with(
                'catalog_error',
                'El catálogo estará disponible muy pronto. Mientras tanto, pide apoyo a tu asesor.',
            );
        }

        return response()->download($path, 'catalogo-distribuidores-sensacional.pdf');
    }
}
