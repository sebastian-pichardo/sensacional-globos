<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\DistributorLead;
use Illuminate\Http\RedirectResponse;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request): RedirectResponse
    {
        DistributorLead::firstOrCreate([
            'email' => $request->validated('email'),
        ]);

        return back()->with(
            'success',
            '¡Listo! Te contactaremos para convertirte en distribuidor autorizado. Envíos a todo México.',
        );
    }
}
