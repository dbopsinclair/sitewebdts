<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

session_start();
if (!empty($_POST['website'] ?? '')) {
    echo json_encode(['success' => true, 'reference' => 'OK']);
    exit;
}

$now = time();
$last = (int)($_SESSION['elite_us_last_request'] ?? 0);
if ($last && ($now - $last) < 20) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Veuillez patienter quelques secondes avant une nouvelle demande.']);
    exit;
}

function clean(string $value, int $max = 500): string {
    $value = trim(strip_tags($value));
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';
    return function_exists('mb_substr') ? mb_substr($value, 0, $max) : substr($value, 0, $max);
}

$allowedTypes = ['Commande', 'Devis', 'Besoin sur mesure', 'Démonstration'];
$type = clean((string)($_POST['request_type'] ?? ''), 50);
$name = clean((string)($_POST['name'] ?? ''), 120);
$company = clean((string)($_POST['company'] ?? ''), 160);
$emailRaw = trim((string)($_POST['email'] ?? ''));
$email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ? $emailRaw : '';
$phone = clean((string)($_POST['phone'] ?? ''), 40);
$item = clean((string)($_POST['item'] ?? ''), 180);
$budget = clean((string)($_POST['budget'] ?? 'Non précisé'), 100);
$timeline = clean((string)($_POST['timeline'] ?? 'À définir'), 100);
$details = clean((string)($_POST['details'] ?? ''), 5000);
$contactMethod = clean((string)($_POST['contact_method'] ?? 'E-mail'), 50);
$consent = ($_POST['consent'] ?? '') === 'yes';

if (!in_array($type, $allowedTypes, true) || $name === '' || $email === '' || $phone === '' || $item === '' || (function_exists('mb_strlen') ? mb_strlen($details) : strlen($details)) < 10 || !$consent) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Veuillez vérifier les champs obligatoires et votre adresse e-mail.']);
    exit;
}

try {
    $reference = 'EU-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
} catch (Throwable $e) {
    $reference = 'EU-' . date('Ymd-His') . '-' . mt_rand(100, 999);
}

$record = [
    'reference' => $reference,
    'created_at' => date(DATE_ATOM),
    'request_type' => $type,
    'name' => $name,
    'company' => $company,
    'email' => $email,
    'phone' => $phone,
    'item' => $item,
    'budget' => $budget,
    'timeline' => $timeline,
    'details' => $details,
    'contact_method' => $contactMethod,
    'ip_hash' => hash('sha256', (string)($_SERVER['REMOTE_ADDR'] ?? 'unknown'))
];

$storageDir = dirname(__DIR__) . '/storage/requests';
$saved = false;
if (is_dir($storageDir) || @mkdir($storageDir, 0750, true)) {
    $file = $storageDir . '/' . date('Y-m') . '.jsonl';
    $line = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL;
    $saved = @file_put_contents($file, $line, FILE_APPEND | LOCK_EX) !== false;
}

$to = 'dts.eliteus@gmail.com';
$subject = '[Elite-US] ' . $type . ' - ' . $reference . ' - ' . $item;
$replyEmail = str_replace(["\r", "\n"], '', $email);
$body = "Nouvelle demande via elite-us.site\n\n" .
        "Référence: $reference\nType: $type\nNom: $name\nEntreprise: $company\nEmail: $email\nTéléphone: $phone\n" .
        "Solution/Service: $item\nBudget: $budget\nDélai: $timeline\nCanal préféré: $contactMethod\n\nDétails:\n$details\n";
$headers = [
    'From: Elite-US Website <no-reply@elite-us.site>',
    'Reply-To: ' . $replyEmail,
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . PHP_VERSION
];
$mailSent = @mail($to, $subject, $body, implode("\r\n", $headers));

if (!$saved && !$mailSent) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'La demande n’a pas pu être enregistrée. Contactez-nous via WhatsApp ou e-mail.']);
    exit;
}

$_SESSION['elite_us_last_request'] = $now;
echo json_encode(['success' => true, 'reference' => $reference, 'saved' => $saved, 'mail_sent' => $mailSent]);
