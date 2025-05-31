<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    public function testFactory()
    {
        $employee = Employee::factory()->seniorProgrammer()->create([
            'id' => '1',
            'name' => 'farhan wahyudi'
        ]);

        $this->assertNotNull($employee);
    }
}
