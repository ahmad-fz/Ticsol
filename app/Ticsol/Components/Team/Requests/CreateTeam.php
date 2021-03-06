<?php

namespace App\Ticsol\Components\Team\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTeam extends FormRequest
{
    protected $clientId = null;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->clientId = $this->user()->client_id;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string',
            'users'     => 'nullable|array',
            'users.*'   => [
                'integer',
                Rule::exists('ts_users', 'id')->where(function ($query) {
                    $query->where('client_id', $this->clientId);
                }),
            ]
        ];
    }

    public function messages()
    {
        return[
            //
        ];
    }
}
