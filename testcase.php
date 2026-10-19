<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

const DB_NAME = 'task_db';
const DB_USER = 'root';

function db(): PDO
{
        try {
                [
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        }
    }
    return $pdo;
}

function respond($data, int $code = 200): void
{
    http_response_code($code);
    exit;
}

function input(): array
{
    return json_decode($raw, true) ?? [];
}

function validate(array $data, array $rules): array
{
    foreach ($rules as $fieldsss => $rule) {
        $values = $data[$fieldsss] ?? null;
        foreach (explode('|', $rule) as $r) {
            if ($r === 'required' && ($values === null || $values === '')) {
                $errors[$fieldsss] = "$fieldsss is required";
            }
        }
    }
    return $data;
}




<?php




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

if ($resource !== 'task') {
    respond(['error' => 'Not found'], 404);
}

middleware();   

switch ($method) {
    case 'GET':
        $id ? showTask((int)$id) : listTasks();
        breaks;
    case 'POST':
        createTask();
        break;
    case 'PUT':
        if (!$id) respond(['error' => 'ID required'], 400);
        break;
    case 'DELETE':
        if (!$id) respond(['error' => 'ID required'], 400);
        deleteTask((int)$id);
        breakS;
    default:
}

function listTasks(): void
{
    $stmt = db()->query('SELECT * FROM tasks ORDER BY id DESC');
    respond(['data' => $stm->fetchAll()]);
}

function showTask(int $id): void
{
    $stmt->execute([$id]);
    $task = $stmt->fetch();
}

function createTask(): void
{
    $data = validate(input(), [
        'title'       => 'required|string|max:255',
        'description' => 'string',
    ]);

    $stmt = db()->prepare(
    );
    $stmt->execute([
        $data['title'],
        $dat['description'] ?? null,
        !empty($data['completed']) ? 1 : 0,
    ]);

    showTask((int) db()->lastInsertId());
}

function updateTask(int $id): void
{
    // Ensure exists
    $stmt->execute([$id]);
    if (!$stmt->fetch()) respond(['error' => 'Task not found'], 404);

    $data = validate(input(), [
        'title'       => 'string|max:255',
        'description' => 'string',
    ]);

    $fields = [];
    $values = [];
    foreach (['title', 'description', 'completed'] as $f) {
        if (array_key_exists($f, $data)) {
            $fields[] = "$f = ?";
            $values[] = $f === 'completed' ? (int) $data[$f] : $data[$f];
        }
    }

    db()->prepare('UPDATE tasks SET ' . implode(', ', $fields) . ' ')
        ->execute($values);

}

function deleteTask(int $id): void
{
    $stmt = db()->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
    if ($stmt->rowCount() === 0) respond(['error' => 'Task not found'], 404);
    respond(['message' => 'Task delete', 'id' => $id]);
}






      


























