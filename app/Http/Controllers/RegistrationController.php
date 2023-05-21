<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validationErrors = $this->validateRegistrationData($request);
        if ($validationErrors) {
            return response()->json($validationErrors, 422);
        }

        $this->createRegistration($request);

        return response()->json(['message' => 'Inscrição realizada com sucesso.'], 200);
    }

    public function filter(Request $request)
    {
        $columnFilter = $request->query('column');
        $filter = $request->query('filter');
        $eventId = $request->query('eventId');

        $registrations = Registration::where($columnFilter, 'LIKE', '%' . $filter . '%')
            ->where('event', $eventId)
            ->paginate(10);

        return response()->json($registrations, 200);
    }

    public function index(Request $request)
    {
        $registrations = Registration::paginate(10);

        return response()->json($registrations, 200);
    }

    private function validateRegistrationData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'name' => 'required',
            'cpf' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->toArray();
        }

        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $cpf = $request->cpf;

        $hasConflictingRegistrations = Registration::where('cpf', $cpf)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
            })
            ->exists();

        if ($hasConflictingRegistrations) {
            return ['message' => 'Você já possui um evento que acontecerá nessa data.'];
        }

        return null;
    }

    private function createRegistration(Request $request)
    {
        Registration::create([
            'event' => $request->event,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'name' => $request->name,
            'cpf' => $request->cpf,
            'email' => $request->email,
        ]);
    }
}
