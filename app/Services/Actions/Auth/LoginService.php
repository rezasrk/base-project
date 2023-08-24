<?php

namespace App\Services\Actions\Auth;

use App\Models\User;
use App\Services\Actions\Auth\DTO\LoginRequestDTO;
use App\Services\Actions\Auth\DTO\LoginResponseDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class LoginService
{
    public function handle(LoginRequestDTO $loginRequestDTO): LoginResponseDTO
    {
        return new LoginResponseDTO(
            token: $this->getToken($loginRequestDTO)
        );
    }

    private function getToken(LoginRequestDTO $loginRequestDTO): string
    {
        if (!filter_var($loginRequestDTO->getUsername(), FILTER_VALIDATE_EMAIL)) {
            $user = $this->loginWithUsername($loginRequestDTO->getUsername(), $loginRequestDTO->getPassword());
        } else {
            $user = $this->loginWithEmail($loginRequestDTO->getUsername(), $loginRequestDTO->getPassword());
        }

        return $user->createToken('admin')->plainTextToken;
    }

    private function loginWithUsername(string $username, string $password): User
    {
        $check = Auth::attempt([
            'username' => $username,
            'password' => $password,
        ]);

        if ($check) {
            return User::query()->where('username', $username)->first();
        }

        throw new UnauthorizedException();
    }

    private function loginWithEmail(string $email, string $password): User
    {
        $check = Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);

        if ($check) {
            return User::query()->where('email', $email)->first();
        }

        throw new UnauthorizedException();
    }
}
