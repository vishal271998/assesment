<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $candidates = Candidate::paginate(25);
            return response()->json(['data' => $candidates], 200);
        } catch (\Exception $e) {
            // Handle server errors
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function search(Request $request)
    {
        // Validate the query parameters
        $request->validate([
            'first_name' => 'max:40',
            'last_name' => 'max:40',
            'email' => 'email|max:100',
            'contact_number' => 'max:100',
            'gender' => 'integer|nullable',
            'specialization' => 'max:200',
            'work_ex_year' => 'integer|nullable|max:30',
            'candidate_dob' => 'integer|nullable',
        ]);

        try {
            $query = Candidate::query();

            if ($request->has('first_name')) {
                $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
            }

            if ($request->has('last_name')) {
                $query->where('last_name', 'like', '%' . $request->input('last_name') . '%');
            }

            if ($request->has('email')) {
                $query->where('email', $request->input('email'));
            }

            if ($request->has('contact_number')) {
                $query->where('contact_number', $request->input('contact_number'));
            }

            if ($request->has('gender')) {
                $query->where('gender', $request->input('gender'));
            }

            if ($request->has('specialization')) {
                $query->where('specialization', 'like', '%' . $request->input('specialization') . '%');
            }

            if ($request->has('work_ex_year')) {
                $query->where('work_ex_year', $request->input('work_ex_year'));
            }

            if ($request->has('candidate_dob')) {
                $query->where('candidate_dob', $request->input('candidate_dob'));
            }

            $candidates = $query->paginate(25);

            return response()->json(['data' => $candidates], 200);
        } catch (\Exception $e) {
            // Handle server errors
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:40',
            'last_name' => 'max:40',
            'email' => 'nullable|email|max:100',
            'contact_number' => 'max:100',
            'gender' => 'integer|nullable',
            'specialization' => 'max:200',
            'work_ex_year' => 'integer|nullable|max:30',
            'candidate_dob' => 'integer|nullable',
            'address' => 'max:500',
            'resume' => 'file|mimes:pdf,doc,docx|max:2048|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        try {
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes');
            }

            $candidateData = $request->except('resume');
            $candidateData['resume'] = $resumePath ?? null;

            $candidate = Candidate::create($candidateData);

            return response()->json(['message' => 'Candidate created successfully', 'data' => $candidate], 201);
        } catch (\Exception $e) {
            // Handle server errors
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }


}
