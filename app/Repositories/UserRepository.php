<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new user
     * 
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        // Hash the password before creating the user
        $data['password'] = Hash::make($data['password']);
        
        // Create and return the user
        return User::create($data);
    }
    
    /**
     * Find user by email
     * 
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
    
    /**
     * Find user by ID
     * 
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return User::find($id);
    }
    
    /**
     * Update user profile
     * 
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateProfile(User $user, array $data): User
    {
        // Check if password is being updated
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        // Update user data
        $user->update($data);
        
        return $user;
    }
}