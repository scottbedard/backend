<?php

namespace App\Backend\Actions;

use Bedard\Backend\Actions\CreateAction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class CreateUserAction extends CreateAction
{
    /**
     * Handle
     *
     * @param Bedard\Backend\Resource $resource
     * @param \App\Models\User $user
     * @param array $data
     *
     * @return void
     */
    public function handle($resource, $user, $data = [])
    {
        $password = data_get($data, 'form.password');
        
        $confirmation = data_get($data, 'form.confirm_password');

        if ($password !== $confirmation) {
            return redirect()->back()->withErrors([
                'password' => 'Password confirmation does not match password.',
            ]);
        }

        $data['form']['password'] = Hash::make($password);

        unset($data['form']['confirm_password']);

        return parent::handle($resource, $user, $data);
    }
}
