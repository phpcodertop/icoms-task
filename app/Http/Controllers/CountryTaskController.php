<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;

class CountryTaskController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanyUsers()
    {
        // please note: Make sure that the country exists on the database
        // and has a relation with company table on the seeded data
        $countryName = 'Switzerland'; // just a placeholder for the country name for testing
        $country = Country::whereName($countryName)->first();
        $countryUsers = $country->users();

        return response()->json(['users' => $countryUsers], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserCompanies()
    {
        $user = User::first(); // you can choose another user by using
        // $user = User::findOrFail($idWillBeHere); or
        // $user = User::whereName('username will be here')->first();
        $userCompanies = $user->companies;
        return response()->json(['companies' => $userCompanies], 200);
    }

}
