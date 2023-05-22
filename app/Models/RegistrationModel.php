<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationModel extends Model
{
    protected $table = 'registrations';
    protected $fillable = [
        'event', 'start_date', 'end_date', 'name', 'cpf', 'email'
    ];

    public function index()
    {
        return $this->paginate(10);
    }

    public function getByEvent($columnFilter, $filter, $eventId)
    {
        return $this->where($columnFilter, 'LIKE', '%' . $filter . '%')->paginate(10);
    }

    public function createRegistration($data)
    {
        return $this->create($data);
    }
}
