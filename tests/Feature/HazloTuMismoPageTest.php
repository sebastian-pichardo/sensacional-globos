<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HazloTuMismoPageTest extends TestCase
{
    public function test_hazlo_tu_mismo_page_is_rendered(): void
    {
        $this->get(route('hazlo-tu-mismo'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('HazloTuMismo'));
    }
}
