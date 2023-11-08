<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $req){
        $credentials = $req->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication successful
            return response()->json(['success' => 'Login successful.']);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Email or password is not matched'], 401);
        }

    }

    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|regex:/^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{}:"<>?;\',.\/\\`~])[A-Za-z0-9!@#$%^&*()_+\-=\[\]{}:"<>?;\',.\/\\`~]{8,16}$/|confirmed',
            'password_confirmation' => 'required'
        ], [
            'password.regex' => 'The password must be 8-16 characters long and contain at least one letter, one number, and one special character.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'image' => 'unknown_profile.png'
        ];
        $this->userRepository->storeUser($data);

        return response()->json(['register_success' => 'Account registration successful! Please log in to your account']);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
        ->with(['prompt' => 'select_account'])
        ->redirect();
    }
    
    public function handleGoogleCallback(Request $req)
    {
        $user = Socialite::driver('google')->user();

        // Check if the user already exists in the database
        $existingUser = $this->userRepository->findUserByEmail($user->getEmail());

        if ($existingUser) {
            $req->session()->put('user', $existingUser);
            // If the user exists, log them in
            Auth::login($existingUser);
        } else {
            // If the user does not exist, create a new user account
            $data = [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'image' => 'unknown_profile.png'
            ];
            $newUser = $this->userRepository->storeUser($data);
            // Log in the new user
            Auth::login($newUser);
        }

        // Redirect to the home page
        return redirect('/');
    }
}
