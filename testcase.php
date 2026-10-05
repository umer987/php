<?php
// ============================================================
// RAW PHP CRUD API — Tasks
// Run:  php -S localhost:8000
// Test: http://localhost:8000/api.php/tasks
// ============================================================

// ---------- 1. CONFIG & HEADERS ----------
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

const DB_HOST = 'localhost';
const DB_NAME = 'task_db';
const DB_USER = 'root';
const DB_PASS = '';

// ---------- 2. DATABASE CONNECTION (PDO) ----------
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            respond(['error' => 'DB connection failed: ' . $e->getMessage()], 500);
        }
    }
    return $pdo;
}

// ---------- 3. HELPERS ----------
function respond($data, int $code = 200): void
{
    http_response_code($code);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function input(): array
{
    $raw = file_get_contents('php://input');
    return json_decode($raw, true) ?? [];
}

function validate(array $data, array $rules): array
{
    $errors = [];
    foreach ($rules as $field => $rule) {
        $value = $data[$field] ?? null;
        foreach (explode('|', $rule) as $r) {
            if ($r === 'required' && ($value === null || $value === '')) {
                $errors[$field] = "$field is required";
            } elseif ($r === 'string' && $value !== null && !is_string($value)) {
                $errors[$field] = "$field must be a string";
            } elseif (str_starts_with($r, 'max:') && $value !== null) {
                $max = (int) substr($r, 4);
                if (strlen($value) > $max) $errors[$field] = "$field max $max chars";
            } elseif ($r === 'bool' && $value !== null && !is_bool($value) && !in_array($value, [0, 1, '0', '1'], true)) {
                $errors[$field] = "$field must be boolean";
            }
        }
    }
    if ($errors) respond(['errors' => $errors], 422);
    return $data;
}

// ---------- 4. MIDDLEWARE ----------
function middleware(): void
{
    // Example: require API key
    $key = $_SERVER['HTTP_X_API_KEY'] ?? '';
    if ($key !== 'secret-key-123') {
        respond(['error' => 'Unauthorized — send header X-API-Key: secret-key-123'], 401);
    }
}

// ---------- 5. ROUTER ----------
$method = $_SERVER['REQUEST_METHOD'];
$path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts  = array_values(array_filter(explode('/', $path)));   // ['api.php', 'tasks', '5']
array_shift($parts);                                          // remove 'api.php'
$resource = $parts[0] ?? null;
$id       = $parts[1] ?? null;

if ($resource !== 'tasks') {
    respond(['error' => 'Not found'], 404);
}

middleware();   // all /tasks routes require API key

// ---------- 6. ROUTES ----------
switch ($method) {
    case 'GET':
        $id ? showTask((int)$id) : listTasks();
        break;
    case 'POST':
        createTask();
        break;
    case 'PUT':
    case 'PATCH':
        if (!$id) respond(['error' => 'ID required'], 400);
        updateTask((int)$id);
        break;
    case 'DELETE':
        if (!$id) respond(['error' => 'ID required'], 400);
        deleteTask((int)$id);
        break;
    default:
        respond(['error' => 'Method not allowed'], 405);
}

// ---------- 7. CONTROLLERS ----------
function listTasks(): void
{
    $stmt = db()->query('SELECT * FROM tasks ORDER BY id DESC');
    respond(['data' => $stmt->fetchAll()]);
}

function showTask(int $id): void
{
    $stmt = db()->prepare('SELECT * FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
    $task = $stmt->fetch();
    $task ? respond(['data' => $task]) : respond(['error' => 'Task not found'], 404);
}

function createTask(): void
{
    $data = validate(input(), [
        'title'       => 'required|string|max:255',
        'description' => 'string',
        'completed'   => 'bool',
    ]);

    $stmt = db()->prepare(
        'INSERT INTO tasks (title, description, completed) VALUES (?, ?, ?)'
    );
    $stmt->execute([
        $data['title'],
        $data['description'] ?? null,
        !empty($data['completed']) ? 1 : 0,
    ]);

    showTask((int) db()->lastInsertId());
}
