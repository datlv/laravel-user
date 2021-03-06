<?php

namespace Datlv\User\Requests;

use Datlv\Kit\Extensions\Request;

/**
 * Class GroupRequest
 *
 * @property-read \Datlv\User\Group $user_group
 * @package Datlv\User
 */
class GroupRequest extends Request
{
    public $trans_prefix = 'user::group';
    public $rules = [
        'system_name' => 'required|max:128|alpha_dash|unique:user_groups',
        'full_name' => 'required|max:128',
    ];

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
        $this->rules += config('user.group_meta.attributes');

        if ($this->user_group) {
            //update Group
            $this->rules['system_name'] .= ',system_name,' . $this->user_group->id;
        } else {
            //create Group
        }

        return $this->rules;
    }

}
