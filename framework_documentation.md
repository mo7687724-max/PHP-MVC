# PHP MVC Framework: Workflow & Code Explanation

This document provides a deep dive into the internal workings of the framework. We will trace the exact lifecycle of a request from the moment it hits your server until the HTML is sent back to the browser, explaining the code in each file along the way.

## 1. The Request Lifecycle (How Files Relate)

When a user opens your application (e.g., navigating to `http://yourdomain.com/`), the following chain reaction occurs:

1. **`.htaccess` (Root)** & **`public/.htaccess`**: The web server receives the request. The root `.htaccess` forwards the request into the `public/` folder. The `public/.htaccess` ensures that if the request isn't for an actual file (like an image), it gets sent to `public/index.php`.
2. **`public/index.php`**: This is the **Front Controller** and the true starting point of the application. It loads all necessary core files, initializes the Router, and dispatches the request.
3. **`routes/web.php`**: Before dispatching, `index.php` loads this file. It contains the "map" that tells the Router which Controller handles which URL.
4. **`app/Core/Router.php`**: The Router compares the requested URL against the map from `web.php`. When it finds a match, it instantiates the corresponding Controller and calls the correct method.
5. **`app/Controllers/HomeController.php`**: The controller contains your application's logic. It can ask a Model for data (optional), and then it calls a View to render the final HTML.
6. **`app/Core/Controller.php`**: The base controller. Your `HomeController` extends this to inherit useful methods, like the `view()` method which actually loads the HTML template.
7. **`resources/views/home/welcome.php`**: The final HTML file that is rendered and sent back to the user's browser.

---

## 2. File-by-File Code Breakdown

Let's look at the actual code driving this process, starting from the entry point.

### A. `public/index.php` (The Starting Point)

Every single request passes through this file. It bootstraps (sets up) the environment.

```php
<?php

// 1. Start a session if one hasn't been started yet.
// This allows you to track users (e.g., login state, shopping carts) across different pages.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Load the Core Framework Files
// We use require_once to load these files so their classes become available.
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Models/Model.php';

// 3. Load the Application Controllers
require_once __DIR__ . '/../app/Controllers/HomeController.php';

// 4. Initialize the Router
// We create an instance of the Router class.
$router = new Router();

// 5. Load Routing Definitions
// This file uses the $router object created above to register all the URLs.
require_once __DIR__ . '/../routes/web.php';

// 6. Dispatch the Request
// This tells the router: "Look at the URL the user wants, find the match, and execute it!"
$router->dispatch();
```

### B. `routes/web.php` (The Map)

This file defines the paths your application understands. It tells the `$router` what to do when a specific URL is hit.

```php
<?php

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

// $router->get() means this route responds to HTTP GET requests.
// Parameter 1 ('/'): The URL path. '/' represents the root of the domain.
// Parameter 2: An array defining [TheControllerToUse, 'TheMethodToCall'].
$router->get(
    '/',
    [HomeController::class, 'index']
);
```
**What this means:** "If a user goes to `http://yourdomain.com/` using a GET request, create an instance of `HomeController` and run its `index()` method."

### C. `app/Core/Router.php` (The Traffic Cop)

This is the most complex part of the core. It stores the routes and executes the correct controller.

```php
<?php

class Router
{
    // Stores all registered routes.
    private array $routes = [];

    // This method is called from web.php to register a GET route.
    public function get(string $path, array $action): void {
        $this->routes['GET'][$path] = [
            'action' => $action
        ];
    }

    // The dispatch method is called at the end of index.php.
    public function dispatch(): void
    {
        // 1. Figure out how the user is accessing the page (GET or POST)
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // 2. Figure out the URL they are asking for (e.g., '/')
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        
        // (Code to clean up the URI and remove base folder names...)

        // 3. Check if the requested route exists in our $routes array
        if (!isset($this->routes[$method][$uri])) {
            // If it doesn't exist, show a 404 error
            http_response_code(404);
            echo '404 - Page Not Found';
            return;
        }

        // 4. Get the controller and method from the matched route
        $route = $this->routes[$method][$uri];
        [
            $controller,  // e.g., 'HomeController'
            $methodName   // e.g., 'index'
        ] = $route['action'];

        // 5. Execute the Controller!
        // This is dynamic instantiation. It's the equivalent of:
        // $controllerInstance = new HomeController();
        // $controllerInstance->index();
        $controllerInstance = new $controller();
        $controllerInstance->$methodName();
    }
}
```

### D. `app/Controllers/HomeController.php` (The Application Logic)

This is where you write your specific application code. Controllers receive requests, process data (often talking to Models), and send a response (often a View).

```php
<?php

// The HomeController extends the base Controller class to inherit useful methods.
class HomeController extends Controller
{
    // This is the method we mapped to the '/' route in web.php
    public function index(): void
    {
        // $this->view() is an inherited method from the base Controller.
        // It tells the framework to load 'resources/views/home/welcome.php'.
        $this->view('home/welcome');
    }
}
```

### E. `app/Core/Controller.php` (The Helper)

This base class provides utility functions to all your specific controllers.

```php
<?php

class Controller
{
    // The view method takes the name of a view file and an array of data.
    public function view(string $view, array $data = []): void
    {
        // 1. Extract variables. 
        // If $data = ['name' => 'John'], extract() turns it into a variable $name = 'John'.
        // This makes it easy to use variables directly inside the HTML template.
        extract($data);

        // 2. Build the exact file path to the view.
        // e.g., C:/laragon/www/PHP-MVC/resources/views/home/welcome.php
        $viewFile = __DIR__ . '/../../resources/views/' . $view . '.php';

        // 3. Check if the file exists, and if so, include (render) it.
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View not found: " . $viewFile);
        }
    }
    
    // Another utility method for easily redirecting users to a different page.
    public function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}
```

### F. `resources/views/home/welcome.php` (The View)

This is a standard PHP/HTML file. Because it was included via the `view()` method in the base controller, any variables passed to it would be available here.

```html
<!-- Example of simple View logic -->
<?php
// Since this is a PHP file, you can write PHP directly inside the HTML to create dynamic content.
$base = (isset($_SERVER['SCRIPT_NAME']) && ($d = dirname($_SERVER['SCRIPT_NAME'])) && $d !== '/' && $d !== '\\') ? preg_replace('#/public$#', '', $d) : '/php-mvc';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome</title>
</head>
<body>
    <header>
        <!-- PHP is used to generate dynamic links -->
        <a href="<?= $base ?>/" class="logo">
            <span>PHP Basic Framework</span>
        </a>
    </header>
    <main>
        <h1>Clean, Fast & Structured PHP</h1>
    </main>
</body>
</html>
```

## Summary Example: Adding a New Page

To test your understanding of the flow, here is how you would add an "About Us" page:

1. **Map the URL (`routes/web.php`)**:
   ```php
   $router->get('/about', [HomeController::class, 'about']);
   ```
2. **Create the Logic (`app/Controllers/HomeController.php`)**:
   ```php
   public function about(): void {
       // We can pass data to the view
       $data = ['title' => 'About Our Company']; 
       $this->view('home/about', $data);
   }
   ```
3. **Create the View (`resources/views/home/about.php`)**:
   ```html
   <h1><?= $title ?></h1> <!-- This will output "About Our Company" -->
   <p>Welcome to our about page.</p>
   ```
