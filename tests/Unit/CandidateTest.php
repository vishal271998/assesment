<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class CandidateTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCandidateWithAllRequiredFields()
    {
        $data = [
            'first_name' => 'test',
            'email' => 'test@gmail.com',
            'contact_number' => '1234567890',
            'gender' => 1,
            'specialization' => 'Computer Science',
            'work_ex_year' => 5,
            'candidate_dob' => '1998',
            'address' => 'abc sdfdsf, sdf',
        ];

        $response = $this->post('/api/candidates', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('candidates', ['first_name' => 'test']);
    }

    public function testCreateCandidateWithSomeOptionalFields()
    {
        $data = [
            'first_name' => 'test2',
            'email' => 'test2@gmail.com',
            'contact_number' => '1234567891',
            'gender' => 2,
            'specialization' => 'Electrical Engineering',
        ];

        $response = $this->post('/api/candidates', $data);

        $response->assertStatus(201); // Expecting a Created status code
        $this->assertDatabaseHas('candidates', ['first_name' => 'test2']);
    }

    public function testCreateCandidateWithInvalidInputs()
    {
        $data = [
            'first_name' => null,
            'email' => 'sdfdsf',
            'gender' => 'sd',
            'specialization' => str_repeat('a', 201),
        ];

        $response = $this->post('/api/candidates', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['first_name', 'email', 'gender', 'specialization']);
    }
}
