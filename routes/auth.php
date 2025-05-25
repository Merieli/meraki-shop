<?php

use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Requests\AuthKitAuthenticationRequest;
use Laravel\WorkOS\Http\Requests\AuthKitLoginRequest;
use Laravel\WorkOS\Http\Requests\AuthKitLogoutRequest;

Route::get('login', function (AuthKitLoginRequest $request) {
    return $request->redirect();
})->middleware(['guest'])->name('login');

Route::get('authenticate', function (AuthKitAuthenticationRequest $request) {
    return tap(to_route('dashboard'), fn () => $request->authenticate());
})->middleware(['guest']);

Route::post('logout', function (AuthKitLogoutRequest $request) {
    return $request->logout();
})->middleware(['auth'])->name('logout');

// $organizations = new WorkOS\Organizations();

// Route::post("/provision-enterprise", function () {
//     $organizationName = "Meraki Shop";
//     $organizationDomains = [
//         [
//             "domain" => "foo-corp.com",
//             "state" => "pending",
//         ],
//     ];

//     $organization = $organizations->createOrganization(
//         name: $organizationName,
//         domain_data: $organizationDomains
//     );

//     // You should persist `organization["id"]` since it will be needed
//     // to generate a Portal Link.

//     // Provision additional Enterprise-tier resources.
// });

// $sso = new WorkOS\SSO();
// Route::get("/auth", function () {
//     // Use the Test Organization ID to get started. Replace it with
//     // the user’s real organization ID when you finish the integration.
//     $organization = "org_test_idp";

//     // The callback URI WorkOS should redirect to after the authentication
//     $redirectUri = "https://dashboard.my-app.com/";

//     $authorizationUrl = $sso->getAuthorizationUrl(
//         organization: $organization,
//         redirectUri: $redirectUri
//     );

//     return redirect($authorizationUrl);
// });