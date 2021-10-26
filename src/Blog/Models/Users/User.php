<?php

namespace Blog\Models\Users;

use Blog\Models\ActiveRecordEntity;
use Blog\Exceptions\InvalidArgumentException;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function singUp(array $userData): User
    {
        // All checks
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Nickname not passed');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentException(
                'Nickname can consist only of Latin alphabet characters and numbers');
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Email not passed');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email is incorrect');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Password not passed');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters long');
        }

        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('User with this nickname already exists');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('User with this email already exists');
        }

        // Create a new user
        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }

    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new InvalidArgumentException('Email not transmitted');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Password not transmitted');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new InvalidArgumentException('There is no user with this email');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Incorrect password');
        }

        if (!$user->isConfirmed) {
            throw new InvalidArgumentException('The user is not confirmed');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    private function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }
}
