<?php
$base = (isset($_SERVER['SCRIPT_NAME']) && ($d = dirname($_SERVER['SCRIPT_NAME'])) && $d !== '/' && $d !== '\\') ? preg_replace('#/public$#', '', $d) : '/php-mvc';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to PHP Basic MVC</title>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --secondary: #0ea5e9;
            --dark: #0f172a;
            --dark-surface: #1e293b;
            --text-main: #334155;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .nav-container {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-badge {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 800;
        }

        /* Hero section */
        .hero {
            padding: 4.5rem 1.5rem 3rem;
            text-align: center;
            background: radial-gradient(circle at 50% 0%, rgba(79, 70, 229, 0.08) 0%, transparent 70%);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .pill-badge {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.35rem 0.9rem;
            border-radius: 9999px;
            font-size: 0.825rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            letter-spacing: 0.02em;
        }

        h1 {
            font-size: 2.75rem;
            color: var(--dark);
            letter-spacing: -0.025em;
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-muted);
            max-width: 650px;
            margin: 0 auto 2rem;
        }

        /* Pipeline section */
        .pipeline-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        .section-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .section-desc {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.925rem;
            margin-bottom: 2rem;
        }

        .pipeline-steps {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            overflow-x: auto;
            padding: 0.5rem 0;
        }

        .pipeline-step {
            flex: 1;
            min-width: 125px;
            background: var(--bg-light);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1rem 0.75rem;
            text-align: center;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .pipeline-step:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
        }

        .step-num {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .step-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .step-desc {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .pipeline-arrow {
            color: var(--border);
            font-size: 1.25rem;
            font-weight: bold;
        }

        /* Architecture Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
            margin: 2.5rem 0;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.06);
            transform: translateY(-2px);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .card-icon {
            width: 38px;
            height: 38px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .card-body {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .code-block {
            background: #0f172a;
            color: #f1f5f9;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.8rem;
            margin-top: 0.75rem;
            overflow-x: auto;
        }

        /* Environment & Status Card */
        .system-info {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 3rem;
            font-size: 0.875rem;
        }

        .info-item strong {
            color: var(--dark);
        }

        .info-item span {
            color: var(--text-muted);
            margin-left: 0.25rem;
        }

        /* Footer */
        footer {
            margin-top: auto;
            border-top: 1px solid var(--border);
            background: #ffffff;
            padding: 1.5rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            .pipeline-steps {
                flex-direction: column;
            }
            .pipeline-arrow {
                transform: rotate(90deg);
                margin: 0.25rem 0;
            }
            .pipeline-step {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="nav-container">
            <a href="<?= $base ?>/" class="logo">
                <span class="logo-badge">MVC</span>
                <span>PHP Basic Framework</span>
            </a>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <span class="pill-badge">🚀 PHP 8.3 &bull; MVC Architecture</span>
                <h1>Clean, Fast & Structured PHP</h1>
                <p>Equipped with PDO database abstraction and clean template rendering.</p>
            </div>
        </section>

        <div class="container">
            <!-- System Stats -->
            <div class="system-info">
                <div class="info-item">
                    <strong>PHP Version:</strong>
                    <span><?= htmlspecialchars(PHP_VERSION) ?></span>
                </div>
                <div class="info-item">
                    <strong>Environment:</strong>
                    <span><?= htmlspecialchars(getenv('APP_ENV') ?: 'local') ?></span>
                </div>
                <div class="info-item">
                    <strong>Base Path:</strong>
                    <span><?= htmlspecialchars($base) ?></span>
                </div>
                <div class="info-item">
                    <strong>Port:</strong>
                    <span><?= htmlspecialchars($_SERVER['SERVER_PORT'] ?? '8080') ?></span>
                </div>
            </div>

            <!-- Execution Pipeline -->
            <div class="pipeline-card">
                <h2 class="section-title">Request Lifecycle & Pipeline</h2>
                <p class="section-desc">Every request flows through distinct, decoupled layers before rendering the view.</p>
                <div class="pipeline-steps">
                    <div class="pipeline-step">
                        <div class="step-num">Step 1</div>
                        <div class="step-name">Router</div>
                        <div class="step-desc">Matches URL & Method</div>
                    </div>
                    <div class="pipeline-arrow">&rarr;</div>
                    <div class="pipeline-step">
                        <div class="step-num">Step 2</div>
                        <div class="step-name">Controller</div>
                        <div class="step-desc">Application Logic</div>
                    </div>
                    <div class="pipeline-arrow">&rarr;</div>
                    <div class="pipeline-step">
                        <div class="step-num">Step 3</div>
                        <div class="step-name">Database</div>
                        <div class="step-desc">PDO &amp; Models</div>
                    </div>
                    <div class="pipeline-arrow">&rarr;</div>
                    <div class="pipeline-step">
                        <div class="step-num">Step 4</div>
                        <div class="step-name">View</div>
                        <div class="step-desc">Rendered HTML</div>
                    </div>
                </div>
            </div>

            <!-- Architecture Grid -->
            <div class="grid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon">⚡</div>
                        <div class="card-title">Controller &amp; Model</div>
                    </div>
                    <div class="card-body">
                        Controllers manage business logic, while models encapsulate table names and schema definitions.
                        <div class="code-block">class User extends Model {<br>&nbsp;&nbsp;public static string $table = 'users';<br>}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            PHP Basic MVC &bull; Clean Architecture
        </div>
    </footer>

</body>
</html>