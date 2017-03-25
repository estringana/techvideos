<?php

namespace Tests\Feature;

use App\Label;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LabelsCanBeCreatedTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function labels_can_be_added()
    {
        $this->post('/labels',
            [
                'label' => 'Some random text',
            ]
        )->assertStatus(201);

        $this->assertCount(1, Label::all());
    }

    /** @test */
    public function it_requires_the_label_to_not_be_empty()
    {
        $this->post('/labels',
            [
                'label' => '',
            ]
        )->assertStatus(302);

        $this->assertCount(0, Label::all());
    }

    /** @test */
    public function a_label_can_not_be_duplicated()
    {
        $label = factory(Label::class)->create([
            'label' => 'Duplicated label',
        ]);

        $this->post('/labels',
            [
                'label' => $label->label,
            ]
        )->assertStatus(302);

        $this->assertCount(1, Label::all());
    }
}
