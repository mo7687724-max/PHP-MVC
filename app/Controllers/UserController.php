<?php

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | READ
    |--------------------------------------------------------------------------
    */

    public function index(): void
    {
        $db = Database::connection();

        $sql = "
            SELECT *
            FROM " . User::$table . "
            ORDER BY id DESC
        ";

        $stmt = $db->query($sql);

        $users = $stmt->fetchAll();

        $this->view(
            'users/index',
            [
                'users' => $users
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $db = Database::connection();

        $sql = "
            SELECT *
            FROM " . User::$table . "
            WHERE id = ?
        ";

        $stmt = $db->prepare($sql);

        $stmt->execute([$id]);

        $user = $stmt->fetch();

        if (!$user) {
            http_response_code(404);
            echo 'User not found';
            return;
        }

        $this->view(
            'users/show',
            [
                'user' => $user
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */

    public function create(): void
    {
        $this->view('users/create');
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function store(): void
    {
        $name = trim(
            $_POST['name'] ?? ''
        );

        $email = trim(
            $_POST['email'] ?? ''
        );

        $password = $_POST['password'] ?? '';


        // Validation

        $validator = new Validator();

        $validator
            ->required('name', $name)
            ->min('name', $name, 3)
            ->max('name', $name, 100)

            ->required('email', $email)
            ->email('email', $email)

            ->required('password', $password)
            ->min('password', $password, 6);


        if ($validator->hasErrors()) {
            $this->view(
                'users/create',
                [
                    'errors' => $validator->errors(),
                    'old' => [
                        'name' => $name,
                        'email' => $email,
                    ]
                ]
            );

            return;
        }


        // CRUD

        $db = Database::connection();

        $sql = "
            INSERT INTO " . User::$table . "
            (name, email, password)
            VALUES (?, ?, ?)
        ";

        $stmt = $db->prepare($sql);

        $stmt->execute([
            $name,
            $email,
            password_hash(
                $password,
                PASSWORD_DEFAULT
            )
        ]);


        $this->redirect(
            '/php-mvc/users'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT FORM
    |--------------------------------------------------------------------------
    */

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $db = Database::connection();

        $sql = "
            SELECT *
            FROM " . User::$table . "
            WHERE id = ?
        ";

        $stmt = $db->prepare($sql);

        $stmt->execute([$id]);

        $user = $stmt->fetch();

        if (!$user) {
            http_response_code(404);
            echo 'User not found';
            return;
        }

        $this->view(
            'users/edit',
            [
                'user' => $user
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $name = trim(
            $_POST['name'] ?? ''
        );

        $email = trim(
            $_POST['email'] ?? ''
        );


        // Validation

        $validator = new Validator();

        $validator
            ->required('name', $name)
            ->min('name', $name, 3)
            ->max('name', $name, 100)

            ->required('email', $email)
            ->email('email', $email);


        if ($validator->hasErrors()) {
            $user = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
            ];

            $this->view(
                'users/edit',
                [
                    'user' => $user,
                    'errors' => $validator->errors()
                ]
            );

            return;
        }


        // CRUD

        $db = Database::connection();

        $sql = "
            UPDATE " . User::$table . "
            SET
                name = ?,
                email = ?
            WHERE id = ?
        ";

        $stmt = $db->prepare($sql);

        $stmt->execute([
            $name,
            $email,
            $id
        ]);


        $this->redirect(
            '/php-mvc/users'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $db = Database::connection();

        $sql = "
            DELETE FROM " . User::$table . "
            WHERE id = ?
        ";

        $stmt = $db->prepare($sql);

        $stmt->execute([$id]);

        $this->redirect(
            '/php-mvc/users'
        );
    }
}

