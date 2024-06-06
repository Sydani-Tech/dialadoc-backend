<?php

namespace App\Http\Requests\API;

use App\Models\ModelRole;
use InfyOm\Generator\Request\APIRequest;

class UpdateRoleAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ModelRole::$rules;

        $id = $this->route('role');

        $rules['name'] = 'required|string|max:255|unique:roles,name,' . $id;

        return $rules;
    }
}
