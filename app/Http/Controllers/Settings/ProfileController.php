<?php

namespace MerakiShop\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\WorkOS\Http\Requests\AuthKitAccountDeletionRequest;
use MerakiShop\Http\Controllers\Controller;
use MerakiShop\Models\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Throwable;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     *
     * @throws Throwable
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile settings.
     * @throws Throwable
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = $request->user();
        abort_if(!$user, 403);

        $user->update([
            'name' => $request->name
        ]);

        return to_route('profile.edit');
    }

    /**
     * Delete the user's account.
     *
     * @throws Throwable
     */
    public function destroy(AuthKitAccountDeletionRequest $request): RedirectResponse
    {
        return $request->delete(
            using: fn (User $user) => $user->delete()
        );
    }
}
