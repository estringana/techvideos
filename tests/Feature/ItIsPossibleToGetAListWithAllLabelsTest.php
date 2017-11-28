<?php

namespace Tests\Feature;

use App\Label;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ItIsPossibleToGetAListWithAllLabelsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function noLabelsShouldBeReturnedWhenThereIsNoneOnTheDb()
    {
        $empty = [];
        $this->get('/api/labels')
            ->assertStatus(200)
            ->assertJson($empty);
    }

    /** @test */
    public function labelsOnTheDbAreReturned()
    {
        $labels = factory(Label::class, 2)->create([]);

        $this->get('/api/labels')
            ->assertStatus(200)
            ->assertJson($labels->toArray());
    }
}
