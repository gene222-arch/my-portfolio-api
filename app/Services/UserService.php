<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function updateDetails(
        User $user,
        string $name,
        string $email,
        string $password,
        string $phoneNumber,
        string $address,
        string $city,
        string $state,
        int $zipCode,
        string $country
    ): User|string
    {
        try {
            $user = DB::transaction(function () use (
                $user,
                $name,
                $email,
                $password,
                $phoneNumber,
                $address,
                $city,
                $state,
                $zipCode,
                $country,
            )
            {
                $user->update([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                ]);

                $user->details()->update([
                    'phone_number' => $phoneNumber
                ]);

                $user->address()->update([
                    'address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'zip_code' => $zipCode,
                    'country' => $country
                ]);

                $relations = [
                    'address',
                    'details',
                    'socialMediaAccounts'
                ];
        
                $user = User::with($relations)->find($user->id);

                return $user;
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $user;
    }
}