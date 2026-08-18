<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $whatsapp = config('globos.whatsapp');
        $message = config('globos.whatsapp_message');

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'appUrl' => rtrim((string) config('app.url'), '/'),
            'brand' => [
                'name' => config('globos.name'),
                'shipping' => config('globos.shipping'),
                'whatsapp' => $whatsapp,
                'whatsappUrl' => 'https://wa.me/'.$whatsapp.'?text='.rawurlencode($message),
                'social' => config('globos.social'),
                'seoDescription' => config('globos.seo.description'),
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'catalog' => $request->session()->get('catalog'),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
