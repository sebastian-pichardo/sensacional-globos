<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProductosPageTest extends TestCase
{
    public function test_productos_page_is_rendered(): void
    {
        $this->get(route('productos'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Productos'));
    }
}
