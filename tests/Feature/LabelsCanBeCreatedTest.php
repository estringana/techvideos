<?php

namespace Tests\Feature;

use App\Label;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LabelsCanBeCreatedTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function labels_can_be_added_when_authenticated()
    {
        Passport::actingAs(factory(User::class)->create(), []);

        $this->post('/api/labels',
            [
                'name' => 'Some random text',
            ]
        )->assertStatus(201);

        $this->assertCount(1, Label::all());
    }

    /** @test */
    public function it_is_not_possible_to_add_a_label_when_not_authenticated()
    {
        $this->post('/api/labels',
            [
                'name' => 'Some random text',
            ]
        )->assertStatus(302);

        $this->assertCount(0, Label::all());
    }

    /** @test */
    public function it_requires_the_label_to_not_be_empty()
    {
        Passport::actingAs(factory(User::class)->create(), []);

        $this->post('/api/labels',
            [
                'name' => '',
            ]
        )->assertStatus(302);

        $this->assertCount(0, Label::all());
    }

    /** @test */
    public function a_label_can_not_be_duplicated()
    {
        Passport::actingAs(factory(User::class)->create(), []);

        $label = factory(Label::class)->create([
            'name' => 'Duplicated label',
        ]);

        $this->post('/api/labels',
            [
                'name' => $label->name,
            ]
        )->assertStatus(302);

        $this->assertCount(1, Label::all());
    }
}
