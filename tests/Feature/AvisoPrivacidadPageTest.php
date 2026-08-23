<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AvisoPrivacidadPageTest extends TestCase
{
    public function test_aviso_de_privacidad_page_is_rendered(): void
    {
        $this->get(route('aviso-de-privacidad'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('AvisoPrivacidad'));
    }
}
