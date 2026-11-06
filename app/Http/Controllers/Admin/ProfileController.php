<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesMedia;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    use ManagesMedia;

    public function edit(): View
    {
        return view('admin.profile.edit', [
            'user' => request()->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        unset($data['avatar'], $data['current_password'], $data['password']);

        if ($request->filled('password')) {
            $data['password'] = $request->input('password');
        }

        if ($request->hasFile('avatar')) {
            $oldAvatar = $user->avatar;
            $data['avatar'] = $this->storeUpload($request->file('avatar'), 'avatars');
            $this->deleteUpload($oldAvatar);
        }

        $user->update($data);

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated.');
    }
}
