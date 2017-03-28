<?php

namespace Tests\Unit;

use App\Label;
use Illuminate\Database\QueryException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LabelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_label_can_not_be_duplicated()
    {
        $randomName = 'Something';

        factory(Label::class)->create([
            'name' => $randomName
        ]);

        $this->expectException(QueryException::class);

        factory(Label::class)->create([
            'name' => $randomName
        ]);
    }
}
