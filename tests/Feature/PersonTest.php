<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    public function testPerson()
    {
        $person = new Person();
        $person->first_name = 'farhan';
        $person->last_name = 'wahyudi';
        $person->save();

        $this->assertEquals('farhan wahyudi', $person->full_name);

        $person->full_name = 'joko anwar';
        $person->save();

        $this->assertEquals('joko', $person->first_name);
        $this->assertEquals('anwar', $person->last_name);
    }
}
