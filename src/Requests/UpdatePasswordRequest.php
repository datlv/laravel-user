<?php
namespace Datlv\User\Requests;

use Datlv\Kit\Extensions\Request;

class UpdatePasswordRequest extends Request
{
    public $trans_prefix = 'user::account';
    public $rules = [
        'password_now' => 'required|password_check',
        'password'     => 'required|between:4,16|confirmed',
    ];

    /**
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
        return $this->rules;
    }

}
