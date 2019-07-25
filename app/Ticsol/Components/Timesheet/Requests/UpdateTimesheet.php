<?php

namespace App\Ticsol\Components\Timesheet\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimesheet extends FormRequest
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
        return [
            'assigned_id'               => 'nullable|numeric|exists:ts_users,id',            
            'total_hours'               => 'required|string',   
            'status'                    => 'required|string|in:submitted,draft',
            'items'                     => 'nullable|array',
            'items.*.user_id'           => 'required_with:items|numeric',
            'items.*.job_id'            => 'required_with:items|numeric',
            'items.*.status'            => 'required_with:items|string|in:tentative,confirmed',  
            'items.*.type'              => 'required_with:items|string|in:timesheet',
            'items.*.event_type'        => 'required_with:items|string|in:leave,scheduled,RDO',    
            'items.*.start'             => 'required_with:items|date',
            'items.*.end'               => 'required_with:items|date', 
            'items.*.billable'          => 'required_with:items|boolean',           
            'items.*.break_length'      => 'required_with:items|string'
        ];
    }

    public function messages()
    {
        return[
            //
        ];
    }
}
