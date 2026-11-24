<?php

namespace App\Http\Controllers;

use App\Models\ClientePotencial;
use App\Models\NewsletterSubscriber;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class DashboardCorreosController extends Controller
{
    public function catalogos(): Response
    {
        return $this->vista(
            titulo: 'Descarga de catálogos',
            descripcion: 'Correos registrados al solicitar el catálogo general o el de temporada.',
            rutaPdf: 'dashboard.catalogos.pdf',
            columnas: $this->columnasCatalogo(),
            registros: $this->registrosCatalogo(),
        );
    }

    public function catalogosPdf(): HttpResponse
    {
        return $this->pdf(
            titulo: 'Correos de descarga de catálogos',
            archivo: 'correos-descarga-catalogos.pdf',
            columnas: $this->columnasCatalogo(),
            registros: $this->registrosCatalogo(),
        );
    }

    public function newsletter(): Response
    {
        return $this->vista(
            titulo: 'Newsletter',
            descripcion: 'Correos registrados en el formulario del newsletter.',
            rutaPdf: 'dashboard.newsletter.pdf',
            columnas: $this->columnasNewsletter(),
            registros: $this->registrosNewsletter(),
        );
    }

    public function newsletterPdf(): HttpResponse
    {
        return $this->pdf(
            titulo: 'Correos del newsletter',
            archivo: 'correos-newsletter.pdf',
            columnas: $this->columnasNewsletter(),
            registros: $this->registrosNewsletter(),
        );
    }

    /**
     * @param  list<array{clave: string, etiqueta: string}>  $columnas
     * @param  list<array<string, string>>  $registros
     */
    private function vista(string $titulo, string $descripcion, string $rutaPdf, array $columnas, array $registros): Response
    {
        return Inertia::render('Dashboard/Correos', [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'exportUrl' => route($rutaPdf),
            'columnas' => $columnas,
            'registros' => $registros,
        ]);
    }

    /**
     * @param  list<array{clave: string, etiqueta: string}>  $columnas
     * @param  list<array<string, string>>  $registros
     */
    private function pdf(string $titulo, string $archivo, array $columnas, array $registros): HttpResponse
    {
        return Pdf::loadView('dashboard.correos-pdf', [
            'titulo' => $titulo,
            'columnas' => $columnas,
            'registros' => $registros,
            'generado' => $this->formatearFecha(now()),
        ])->download($archivo);
    }

    /**
     * @return list<array{clave: string, etiqueta: string}>
     */
    private function columnasCatalogo(): array
    {
        return [
            ['clave' => 'email', 'etiqueta' => 'Correo'],
            ['clave' => 'catalogo', 'etiqueta' => 'Catálogo'],
            ['clave' => 'fecha', 'etiqueta' => 'Fecha de registro'],
        ];
    }

    /**
     * @return list<array{clave: string, etiqueta: string}>
     */
    private function columnasNewsletter(): array
    {
        return [
            ['clave' => 'email', 'etiqueta' => 'Correo'],
            ['clave' => 'fecha', 'etiqueta' => 'Fecha de registro'],
        ];
    }

    /**
     * @return list<array<string, string>>
     */
    private function registrosCatalogo(): array
    {
        return ClientePotencial::query()
            ->whereIn('medio', ['catalogo-general', 'catalogo-temporada'])
            ->latest()
            ->get()
            ->map(fn (ClientePotencial $cliente): array => [
                'email' => $cliente->email,
                'catalogo' => $cliente->medio === 'catalogo-temporada'
                    ? 'Catálogo de temporada'
                    : 'Catálogo general',
                'fecha' => $this->formatearFecha($cliente->created_at),
            ])
            ->all();
    }

    /**
     * @return list<array<string, string>>
     */
    private function registrosNewsletter(): array
    {
        return NewsletterSubscriber::query()
            ->latest()
            ->get()
            ->map(fn (NewsletterSubscriber $suscriptor): array => [
                'email' => $suscriptor->email,
                'fecha' => $this->formatearFecha($suscriptor->created_at),
            ])
            ->all();
    }

    private function formatearFecha(?Carbon $fecha): string
    {
        if ($fecha === null) {
            return '—';
        }

        return $fecha
            ->timezone('America/Mexico_City')
            ->locale('es')
            ->isoFormat('D MMM YYYY, HH:mm');
    }
}
