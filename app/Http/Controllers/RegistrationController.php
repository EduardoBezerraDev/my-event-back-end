<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RegistrationModel;

class RegistrationController extends Controller
{
    private $registrationModel;
    
    public function __construct(RegistrationModel $registrationModel)
    {
        $this->registrationModel = $registrationModel;
    }

    public function store(Request $request)
    {
        $validationErrors = $this->validateRegistrationData($request);
        if ($validationErrors) {
            return response()->json($validationErrors, 422);
        }

        $this->registrationModel->createRegistration([
            'event' => $request->event,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'name' => $request->name,
            'cpf' => $request->cpf,
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'Inscrição realizada com sucesso.'], 200);
    }

    public function filter(Request $request)
    {
        $columnFilter = $request->query('column');
        $filter = $request->query('filter');
        $eventId = $request->query('eventId');
        $registrations = $this->registrationModel->getByEvent($columnFilter, $filter,  $eventId);

        return response()->json($registrations, 200);
    }

    public function index(Request $request)
    {
        $registrations = $this->registrationModel->index();

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

        $hasConflictingRegistrations = $this->registrationModel
            ->where('cpf', $cpf)
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
}
