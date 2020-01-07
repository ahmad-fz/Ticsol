<?php

namespace App\Ticsol\Components\Job\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Ticsol\Base\Rules;
use App\Ticsol\Components\Models\Job;
use App\Ticsol\Components\Models\Form;
use App\Ticsol\Components\Job\Rules as JobRules;

class UpdateJob extends FormRequest
{
    protected $job;
    protected $parent;
    protected $profile;
    protected $clientId = null;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $jobId = $this->route()->parameter("id");
        $parentId = $this->input('parent_id', null);
        $profileId = $this->input('form_id', null);

        $this->clientId = $this->user()->client_id;   
        $this->job = Job::where('id', $jobId)->first();             
        $this->parent = Job::where('id', $parentId)->first();      
        $this->profile = Form::where('id', $profileId)->first();

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
            'title'                 => 'string|between:1,100',
            'code'                  => 'string|between:1,100',
            'color'                 => 'nullable|string|regex:/^#([a-z0-9]){6}$/i',
            'isactive'              => 'boolean',
            'contacts'              => 'nullable|array',
            'meta'                  => 'nullable',

            // QBs
            'qbs_id'                => 'integer',

            // billing
            'payment_type'          => 'string|in:prepaid,inArrears',
            'rate'                  => 'numeric|min:0',
            'unit_type'             => 'string|in:minutes,days',
            'unit'                  => 'numeric|min:0',
            'allow_over_billing'    => 'boolean',
            'job_fallback_rate'     => 'string|in:sameRate,companyDefault',
            'revenue_account_id'    => 'nullable|numeric',

            // foreign keys
            'parent_id'     => [
                'nullable', 
                'integer',
                Rule::exists('ts_jobs', 'id')->where(function ($query) {
                    $query->where('client_id', $this->clientId);
                }),
                new JobRules\JobParent($this->profile),
                new Rules\HierarchyDepth($this->parent, 3),
                new Rules\HierarchyCycle($this->job),
                new Rules\HierarchyFatherMove($this->job)
            ],

            'form_id' => [
                'nullable',
                'integer',
                Rule::exists('ts_forms', 'id')->where(function ($query) {
                    $query->where('client_id', $this->clientId);
                }),
            ],     
                       
            'contacts.*'    => [
                'integer',
                Rule::exists('ts_contacts', 'id')->where(function ($query) {
                    $query->where('client_id', $this->clientId);
                })
            ],            
        ];
    }

    public function messages()
    {
        return[
            //
        ];
    }
}
