<?php
namespace Datlv\User\Controllers;

use Datlv\Kit\Extensions\Controller;
use  Datlv\User\Requests\UpdatePasswordRequest;
use  Datlv\User\Requests\UpdateProfileRequest;
use Illuminate\Contracts\Auth\Guard;
use Session;

/**
 * Class AccountController
 *
 * @package Datlv\User\Controllers\Backend
 */
class AccountController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function showPassword()
    {
        return view('user::update_password');
    }

    /**
     * @param \Datlv\User\Requests\UpdatePasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function password(UpdatePasswordRequest $request)
    {
        $user = user();
        $user->password = $request->get('password');
        $user->save();
        $this->auth->logout();
        Session::flash(
            'message',
            [
                'type'    => 'success',
                'content' => trans('user::account.change_password_success'),
            ]
        );

        return redirect(route('auth.login'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function showProfile()
    {
        $account = user();
        return view('user::profile', compact('account'));
    }

    /**
     * @param \Datlv\User\Requests\UpdateProfileRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function profile(UpdateProfileRequest $request)
    {
        $account = user();
        $account->fill($request->except(['password', 'username']));
        $account->save();
        Session::flash(
            'message',
            [
                'type'    => 'success',
                'content' => trans('user::account.update_profile_success'),
            ]
        );

        return redirect(route('backend.dashboard'));
    }
}
