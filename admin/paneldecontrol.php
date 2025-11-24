<?php
require __DIR__ . '/../includes/config.php';

// 1. VERIFICACIÓN DE SESIÓN
if (!isset($_SESSION['usuario'])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}
$usuario = $_SESSION['usuario'];
$user_rol = $_SESSION['rol'];

// Mensajes Flash (de eliminar, editar, etc.)
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
$tipo_mensaje = isset($_SESSION['tipo_mensaje']) ? $_SESSION['tipo_mensaje'] : '';
unset($_SESSION['mensaje']);
unset($_SESSION['tipo_mensaje']);


// 2. OBTENER TODOS LOS PARÁMETROS (Filtros y Paginación)
$search = trim($_GET['search'] ?? '');
$carrera_filter = trim($_GET['carrera'] ?? '');
$localidad_filter = trim($_GET['localidad'] ?? '');
$page_insc = (int)($_GET['page_insc'] ?? 1);
$page_msg = (int)($_GET['page_msg'] ?? 1);


// 3. LÓGICA DE INSCRIPCIONES (Paginación y Filtros)
$per_page_insc = 10;
$offset_insc = ($page_insc - 1) * $per_page_insc;

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
$where_sql = implode(" AND ", $where_clauses);

// Conteo de Inscripciones
$count_sql_insc = "SELECT COUNT(*) as total FROM preinscripciones WHERE $where_sql";
$stmt_insc_count = $conn->prepare($count_sql_insc);
if (!empty($params)) {
    $stmt_insc_count->bind_param($types, ...$params);
}
$stmt_insc_count->execute();
$total_items_insc = $stmt_insc_count->get_result()->fetch_assoc()['total'];
$total_pages_insc = ceil($total_items_insc / $per_page_insc);
$stmt_insc_count->close();

// Obtener Inscripciones (Paginadas)
$sql_insc = "SELECT * FROM preinscripciones WHERE $where_sql ORDER BY creadoa DESC LIMIT ? OFFSET ?";
$params_with_pagination = $params;
$params_with_pagination[] = $per_page_insc;
$params_with_pagination[] = $offset_insc;
$types_with_pagination = $types . "ii";

$stmt_insc = $conn->prepare($sql_insc);
if (!empty($params_with_pagination)) {
    $stmt_insc->bind_param($types_with_pagination, ...$params_with_pagination);
}
$stmt_insc->execute();
$result_insc = $stmt_insc->get_result();
$stmt_insc->close(); // Cerramos el statement de inscripciones


// 4. LÓGICA DE MENSAJES (Paginación)
$per_page_msg = 10;
$offset_msg = ($page_msg - 1) * $per_page_msg;

// Conteo de Mensajes
$count_sql_msg = "SELECT COUNT(*) as total FROM mensajes_contacto";
$total_items_msg = $conn->query($count_sql_msg)->fetch_assoc()['total'];
$total_pages_msg = ceil($total_items_msg / $per_page_msg);

// Obtener Mensajes (Paginados)
$sql_mensajes = "SELECT * FROM mensajes_contacto ORDER BY creadoa DESC LIMIT ? OFFSET ?";
$stmt_msg = $conn->prepare($sql_mensajes);
$stmt_msg->bind_param("ii", $per_page_msg, $offset_msg);
$stmt_msg->execute();
$result_mensajes = $stmt_msg->get_result();
$stmt_msg->close(); // Cerramos el statement de mensajes


// 5. DICCIONARIOS (Para nombres legibles)
// Se añade una definición básica de $localidades para que funcione si no está en config.php
if (!isset($localidades)) {
    $localidades = ['alberdi', 'aguilares', 'concepcion', 'graneros', 'lacocha', 'lamadrid', 'santana', 'villabel', 'otraloc'];
}

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

// 6. PARÁMETROS DE URL (Para paginación)
// Parámetros de filtro para mantenerlos en los enlaces de paginación
$filter_params = http_build_query([
    'search' => $search,
    'carrera' => $carrera_filter,
    'localidad' => $localidad_filter
]);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - IES La Cocha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>styles.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>stylespanel.css">
</head>
<body>
    <nav class="navbar-custom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="navbar-title">IES La Cocha</h3>
                    <small class="navbar-subtitle">Panel de Control</small>
                </div>
                
                <div class="navbar-user">
                    <span>Bienvenido, <strong><?php echo htmlspecialchars($usuario); ?></strong></span>
                    <a href="<?php echo BASE_URL; ?>index.php" class="btn btn-light btn-sm">Volver al Inicio</a>
                    <a href="<?php echo BASE_URL; ?>logout.php" class="btn btn-light btn-sm">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($mensaje): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
            
        <ul class="nav nav-tabs" id="adminTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="inscripciones-tab" data-bs-toggle="tab" data-bs-target="#inscripciones-panel" type="button" role="tab" aria-controls="inscripciones-panel" aria-selected="true">
                    Preinscripciones (<?php echo $total_items_insc; ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="mensajes-tab" data-bs-toggle="tab" data-bs-target="#mensajes-panel" type="button" role="tab" aria-controls="mensajes-panel" aria-selected="false">
                    Mensajes (<?php echo $total_items_msg; ?>)
                </button>
            </li>
        </ul>
        
        <div class="tab-content" id="adminTabContent">

            <div class="tab-pane fade show active" id="inscripciones-panel" role="tabpanel" aria-labelledby="inscripciones-tab">
                
                <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
                    <h2>Gestión de Inscripciones</h2>
                    <?php if ($user_rol === 'admin'): ?>
                               <div style="display:flex; gap:0.5rem; align-items:center;">
                                    <a href="crear_inscripcion.php" class="btn btn-primary">+ Nueva Inscripción</a>
                                    <button type="button" id="btnExportCsv" class="btn btn-outline-success">Exportar Excel</button>
                                    <button type="button" id="btnExportPdf" class="btn btn-outline-danger">Exportar PDF</button>
                               </div>
                    <?php endif; ?>
                </div>

                <div class="table-container mb-4">
                    <form method="GET" action="#inscripciones-tab" class="d-flex" style="gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
                        <input type="text" name="search" class="form-control" style="flex: 2; min-width: 200px;"
                               placeholder="Buscar por nombre, apellido, email o DNI..." 
                               value="<?php echo htmlspecialchars($search); ?>">
                        <select name="carrera" class="form-control" style="flex: 1; min-width: 200px;">
                            <option value="">Todas las carreras</option>
                            <?php foreach ($carreras_nombres as $valor => $nombre_completo): ?>
                                <option value="<?php echo htmlspecialchars($valor); ?>" <?php echo $carrera_filter === $valor ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($nombre_completo); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="localidad" class="form-control" style="flex: 1; min-width: 150px;">
                            <option value="">Todas las localidades</option>
                            <?php foreach ($localidades as $loc): ?>
                                <option value="<?php echo htmlspecialchars($loc); ?>" <?php echo $localidad_filter === $loc ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($localidades_nombres[$loc]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-secondary">Filtrar</button>
                        <?php if ($search !== '' || $carrera_filter !== '' || $localidad_filter !== ''): ?>
                            <a href="paneldecontrol.php#inscripciones-tab" class="btn btn-light">Limpiar</a>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="table-container">
                    <p class="text-muted">Mostrando <?php echo $result_insc->num_rows; ?> de <?php echo $total_items_insc; ?> inscripciones</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Completo</th>
                                    <th>DNI</th>
                                    <th>Genero</th>
                                    <th>Domicilio</th> 
                                    <th>Contacto</th>
                                    <th>Carrera</th>
                                    <th>Fecha de Inscripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($result_insc->num_rows > 0): ?>
                                <?php while ($row = $result_insc->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?></td>
                                        <td><?php echo htmlspecialchars($row['dni']); ?></td>
                                        <td><?php echo htmlspecialchars($row['genero']); ?></td>
                                        <td><?php $nombre_loc = $localidades_nombres[$row['localidad']] ?? $row['localidad']; echo htmlspecialchars($row['direccion'] . ' - ' . $nombre_loc); ?></td>
                                        <td><div><span style="text-transform: lowercase; font-weight: 600;"><?php echo htmlspecialchars($row['email']); ?></span></div><div style="font-size: 0.9em; color: #666;"><?php echo htmlspecialchars($row['telefono']); ?></div></td>
                                        <td><?php echo htmlspecialchars($carreras_nombres[$row['carrera']] ?? $row['carrera']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($row['creadoa'])); ?></td>
                                        <td style="white-space: nowrap;">
                                            <?php if ($user_rol === 'admin'): ?>
                                                <a href="editar_inscripcion.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                                <button onclick="confirmarEliminarInsc(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars(addslashes($row['nombre'] . ' ' . $row['apellido'])); ?>')" 
                                                             class="btn btn-danger btn-sm">Eliminar</button>
                                            <?php else: ?>
                                                <span class="text-muted">Sin permisos</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="9" class="text-center text-muted">No se encontraron inscripciones</td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($total_pages_insc > 1): ?>
                        <nav class="mt-4">
                            <ul class="pagination" style="justify-content: center;">
                                <?php if ($page_insc > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page_insc=<?php echo $page_insc - 1; ?>&page_msg=<?php echo $page_msg; ?>&<?php echo $filter_params; ?>#inscripciones-tab">Anterior</a>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item disabled"><span class="page-link">Página <?php echo $page_insc; ?> de <?php echo $total_pages_insc; ?></span></li>
                                <?php if ($page_insc < $total_pages_insc): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page_insc=<?php echo $page_insc + 1; ?>&page_msg=<?php echo $page_msg; ?>&<?php echo $filter_params; ?>#inscripciones-tab">Siguiente</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>

            </div> <div class="tab-pane fade" id="mensajes-panel" role="tabpanel" aria-labelledby="mensajes-tab">
                
                <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
                    <h2>Gestión de Mensajes de Contacto</h2>
                </div>

                <div class="table-container">
                    <p class="text-muted">Mostrando <?php echo $result_mensajes->num_rows; ?> de <?php echo $total_items_msg; ?> mensajes</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Nombre Completo</th><th>Email</th><th>Teléfono</th>
                                    <th>Interés</th><th>Fecha</th><th>Mensaje</th><th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_mensajes->num_rows > 0): ?>
                                    <?php while ($row = $result_mensajes->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?></td>
                                            <td style="text-transform: lowercase;"><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                                            <td><?php echo htmlspecialchars($carreras_nombres[$row['interes']] ?? $row['interes']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($row['creadoa'])); ?></td>
                                            <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" 
                                                title="<?php echo htmlspecialchars($row['mensaje']); ?>">
                                                <?php echo htmlspecialchars($row['mensaje']); ?>
                                            </td>
                                            <td style="white-space: nowrap;">
                                                <button onclick="confirmarEliminarMsg(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars(addslashes($row['nombre'] . ' ' . $row['apellido'])); ?>')" 
                                                             class="btn btn-danger btn-sm">Eliminar</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="8" class="text-center text-muted">No se encontraron mensajes</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($total_pages_msg > 1): ?>
                        <nav class="mt-4">
                            <ul class="pagination" style="justify-content: center;">
                                <?php if ($page_msg > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page_msg=<?php echo $page_msg - 1; ?>&page_insc=<?php echo $page_insc; ?>&<?php echo $filter_params; ?>#mensajes-tab">Anterior</a>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item disabled"><span class="page-link">Página <?php echo $page_msg; ?> de <?php echo $total_pages_msg; ?></span></li>
                                <?php if ($page_msg < $total_pages_msg): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page_msg=<?php echo $page_msg + 1; ?>&page_insc=<?php echo $page_insc; ?>&<?php echo $filter_params; ?>#mensajes-tab">Siguiente</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>

            </div> </div> </div> <?php include __DIR__ . '/../includes/footer.php'; ?>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script para eliminar Inscripción
    function confirmarEliminarInsc(id, nombre) {
        if (confirm('¿Estás seguro de que deseas eliminar la inscripción de "' + nombre + '"?')) {
            window.location.href = 'eliminar_inscripcion.php?id=' + id;
        }
    }
    
    // Script para eliminar Mensaje
    function confirmarEliminarMsg(id, nombre) {
        if (confirm('¿Estás seguro de que deseas eliminar el mensaje de "' + nombre + '"?')) {
            // Necesitarás crear este archivo: eliminar_mensaje.php
            window.location.href = 'eliminar_mensaje.php?id=' + id;
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script>
    // Obtener valores del formulario de filtros
    function getFilterParams() {
        const form = document.querySelector('#inscripciones-panel form') || document.querySelector('form');
        const params = new URLSearchParams();
        if (!form) return params;
        const search = form.querySelector('input[name="search"]')?.value || '';
        const carrera = form.querySelector('select[name="carrera"]')?.value || '';
        const localidad = form.querySelector('select[name="localidad"]')?.value || '';
        if (search) params.append('search', search);
        if (carrera) params.append('carrera', carrera);
        if (localidad) params.append('localidad', localidad);
        return params;
    }

    async function fetchInscripcionesJson() {
        const params = getFilterParams();
        const url = 'inscripciones_json.php?' + params.toString();
        const resp = await fetch(url, {credentials: 'same-origin'});
        if (!resp.ok) throw new Error('Error al obtener datos: ' + resp.status);
        return resp.json();
    }

    function downloadCsv(rows) {
        const cols = ['ID','Nombre','Apellido','DNI','Genero','Localidad','Direccion','Email','Telefono','Carrera','Fecha'];
        const lines = [cols.join(',')];
        for (const r of rows) {
            const vals = [r.id, r.nombre, r.apellido, r.dni, r.genero, '"' + (r.localidad_nombre || r.localidad) + '"', '"' + (r.direccion || '') + '"', r.email, r.telefono, '"' + (r.carrera_nombre || r.carrera) + '"', r.creadoa];
            lines.push(vals.join(','));
        }
        const csv = '\uFEFF' + lines.join('\n');
        const blob = new Blob([csv], {type: 'text/csv;charset=utf-8;'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'inscripciones_' + new Date().toISOString().slice(0,19).replace(/[:T]/g,'_') + '.csv';
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
    }

    async function exportCsvHandler() {
        try {
            const data = await fetchInscripcionesJson();
            downloadCsv(data.rows);
        } catch (err) {
            alert('Error al exportar CSV: ' + err.message);
        }
    }

    async function exportPdfHandler() {
        try {
            const { jsPDF } = window.jspdf;
            const data = await fetchInscripcionesJson();
            const rows = data.rows.map(r => [r.id, r.nombre, r.apellido, r.dni, r.genero, r.localidad_nombre || r.localidad, r.direccion || '', r.email, r.telefono, r.carrera_nombre || r.carrera, r.creadoa]);
            const doc = new jsPDF({orientation: 'landscape', unit: 'pt', format: 'a4'});
            doc.setFontSize(12);
            doc.text('Listado de Preinscripciones', 40, 40);
            doc.autoTable({
                startY: 60,
                head: [[ 'ID','Nombre','Apellido','DNI','Genero','Localidad','Direccion','Email','Telefono','Carrera','Fecha' ]],
                body: rows,
                styles: { fontSize: 9 }
            });
            doc.save('inscripciones_' + new Date().toISOString().slice(0,19).replace(/[:T]/g,'_') + '.pdf');
        } catch (err) {
            alert('Error al generar PDF: ' + err.message);
        }
    }

    document.getElementById('btnExportCsv')?.addEventListener('click', exportCsvHandler);
    document.getElementById('btnExportPdf')?.addEventListener('click', exportPdfHandler);
</script>
</body>
</html>