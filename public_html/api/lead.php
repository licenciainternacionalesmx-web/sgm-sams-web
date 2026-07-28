<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'message' => 'Método no permitido.']);
  exit;
}
$webhook = getenv('SGM_N8N_LEAD_WEBHOOK');
if (!$webhook || !filter_var($webhook, FILTER_VALIDATE_URL)) {
  http_response_code(503);
  echo json_encode(['ok' => false, 'message' => 'El canal de solicitudes está en configuración.']);
  exit;
}
$clean = static fn(string $key, int $max): string => mb_substr(trim((string)($_POST[$key] ?? '')), 0, $max);
$name = $clean('name', 120);
$whatsapp = preg_replace('/[^0-9+]/', '', $clean('whatsapp', 24));
$email = $clean('email', 160);
$service = $clean('service', 80);
$consent = ($_POST['consent'] ?? '') === 'yes';
if ($name === '' || $whatsapp === '' || $service === '' || !$consent || ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL))) {
  http_response_code(422);
  echo json_encode(['ok' => false, 'message' => 'Revisa los campos obligatorios.']);
  exit;
}
$folio = 'SGM-WEB-' . gmdate('Ymd-His') . '-' . strtoupper(bin2hex(random_bytes(2)));
$payload = [
  'folio' => $folio,
  'source' => 'website_frontdesk',
  'received_at' => gmdate(DATE_ATOM),
  'lead' => [
    'name' => $name,
    'whatsapp' => $whatsapp,
    'email' => $email,
    'location' => $clean('location', 120),
    'service' => $service,
    'destination' => $clean('destination', 100),
    'message' => $clean('message', 1200),
    'consent' => true
  ],
  'compliance' => [
    'status' => 'pending_review',
    'policy_code' => 'SGM-COMPLIANCE-01',
    'policy_version' => '1.2',
    'jurisdiction' => [
      'scope' => 'multi_jurisdiction',
      'detected_country' => null,
      'country_detection_status' => 'pending',
      'applicable_law' => null,
      'law_detection_status' => 'pending'
    ],
    'review_type' => 'automated_policy_review',
    'human_approval_required' => false,
    'publication_allowed' => false,
    'decision' => 'pending',
    'original_content_preserved' => true,
    'automated_correction_allowed' => true,
    'crm_trace_required' => true,
    'approved_by' => null,
    'approved_at' => null,
    'next_action' => 'detect_jurisdiction'
  ]
];
$ch = curl_init($webhook);
curl_setopt_array($ch, [
  CURLOPT_POST => true,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 12,
  CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
  CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
]);
curl_exec($ch);
$code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);
if ($error || $code < 200 || $code >= 300) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'message' => 'La solicitud no pudo registrarse. Intenta nuevamente.']);
  exit;
}
echo json_encode(['ok' => true, 'folio' => $folio]);
