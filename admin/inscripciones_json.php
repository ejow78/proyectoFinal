<?php
require __DIR__ . '/../includes/config.php';

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

header('Content-Type: application/json; charset=utf-8');

$search = trim($_GET['search'] ?? '');
$carrera_filter = trim($_GET['carrera'] ?? '');
$localidad_filter = trim($_GET['localidad'] ?? '');

$where_clauses = ["1=1"];
$params = [];
$types = "";

if ($search !== '') {
    $where_clauses[] = "(nombre LIKE ? OR apellido LIKE ? OR email LIKE ? OR dni LIKE ?)";
    $search_param = "%$search%";
    array_push($params, $search_param, $search_param, $search_param, $search_param);
    $types .= "ssss";
}
if ($carrera_filter !== '') {
    $where_clauses[] = "carrera = ?";
    $params[] = $carrera_filter;
    $types .= "s";
}
if ($localidad_filter !== '') {
    $where_clauses[] = "localidad = ?";
    $params[] = $localidad_filter;
    $types .= "s";
}

$where_sql = implode(' AND ', $where_clauses);

$sql = "SELECT * FROM preinscripciones WHERE $where_sql ORDER BY creadoa DESC";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la consulta', 'details' => $conn->error]);
    exit();
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$localidades_nombres = [
    'alberdi' => 'Juan Bautista Alberdi', 'aguilares' => 'Aguilares', 'concepcion' => 'Concepción',
    'graneros' => 'Graneros', 'lacocha' => 'La Cocha', 'lamadrid' => 'La Madrid',
    'santana' => 'Santa Ana', 'villabel' => 'Villa Belgrano', 'otraloc' => 'Otro/a'
];
$carreras_nombres = [
    'alimentos' => 'Técnico Superior en Agroindustria de los Alimentos',
    'historia' => 'Profesorado de Educación Secundaria en Historia',
    'matematicas' => 'Profesorado de Educación Secundaria en Matemáticas',
    'agropecuaria' => 'Técnico Superior en Gestión de Producción Agropecuaria',
    'software' => 'Técnico Superior en Desarrollo de Software'
];

$rows = [];
while ($r = $result->fetch_assoc()) {
    $r['localidad_nombre'] = $localidades_nombres[$r['localidad']] ?? $r['localidad'];
    $r['carrera_nombre'] = $carreras_nombres[$r['carrera']] ?? $r['carrera'];
    $r['creadoa'] = date('d/m/Y H:i', strtotime($r['creadoa']));
    $rows[] = $r;
}

echo json_encode(['rows' => $rows], JSON_UNESCAPED_UNICODE);

?>
