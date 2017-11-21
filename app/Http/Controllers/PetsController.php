<?php

namespace App\Http\Controllers;

use App\Pet;

use Hash;
use Log;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\CrudController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class PetsController extends CrudController
{
    public function __construct()
    {
    }

    protected function getModel()
    {
        return Pet::class;
    }

    protected function applyFilters(Request $request, $query)
    {
        $query = $query->with(['owner' => function ($query) {
            $query->select('id', 'name');
        }]);

        if ($request->has('name')) {
            $query = $query->where('name', 'ilike', '%'.$request->name.'%');
        }

        if ($request->has('type')) {
            $query = $query->where('type', 'ilike', '%'.$request->type.'%');
        }

        if ($request->has('minAge')) {
            $query = $query->where('age', '>=', $request->minAge);
        }

        if ($request->has('maxAge')) {
            $query = $query->where('age', '<=', $request->maxAge);
        }

        $loggedUser = Auth::user();

        if ($loggedUser != null) {
            $query = $query->where('owner_id', '=', $loggedUser->id);
        } else {
            $query = $query->where('owner_id', '=', null);
        }
    }

    public function abandon(Request $request)
    {
        $pet = Pet::find($request->id);

        $this->validate($request, []);

        if ($pet->owner_id !== Auth::id()) {
            $this->validator->errors()->add('owner', 'Este pet não é seu.');
            $this->throwValidationException($request, $this->validator);
        }

        $pet->owner_id = null;
        $pet->save();
        $pet->owner = null;

        return $pet;
    }

    public function adopt(Request $request)
    {
        $pet = Pet::find($request->id);

        $this->validate($request, []);

        if ($pet->owner_id !== null) {
            $this->validator->errors()->add('owner', 'Este pet já tem dono.');
            $this->throwValidationException($request, $this->validator);
        }

        $pet->owner_id = Auth::id();
        $pet->save();

        $pet->owner = $pet->owner()->select('id', 'name')->get();

        return $pet;
    }

    protected function beforeSearch(Request $request, $dataQuery, $countQuery)
    {
        $dataQuery->orderBy('name', 'asc');
    }

    protected function getValidationRules(Request $request, Model $obj)
    {
        $rules = [
            'name' => 'required|max:100|unique:pets',
            'type' => 'required|max:100',
            'age' => 'min:1|max:20'
        ];

        if (strpos($request->route()->getName(), 'pets.update') !== false) {
            $rules['name'] = 'required|max:255|unique:pets,name,'.$obj->id;
        }

        return $rules;
    }

    protected function beforeStore(Request $request, Model $obj)
    {
        $loggedUserId = Auth::id();

        if ($loggedUserId != null) {
            $obj->owner_id = $loggedUserId;
        }
    }

    protected function beforeUpdate(Request $request, Model $obj)
    {
        $loggedUserId = Auth::id();

        if (($loggedUserId == null && $obj->owner_id != null) || $obj->owner_id !== $loggedUserId) {
            $this->validator->errors()->add('owner', 'É preciso ser dono do Pet.');
            $this->throwValidationException($request, $this->validator);
        }
    }
}
