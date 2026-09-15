<?php

class User extends Model
{
    public static string $table = 'users';

    public static array $fields = [
        'name',
        'email',
        'password',
    ];
}

