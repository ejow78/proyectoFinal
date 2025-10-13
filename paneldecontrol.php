<?php
session_start();
require 'conect.php';
 

$usuario = $_SESSION['usuario'];
$user_rol = $_SESSION['rol'];

$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
$tipo_mensaje = isset($_SESSION['tipo_mensaje']) ? $_SESSION['tipo_mensaje'] : '';
unset($_SESSION['mensaje']);
unset($_SESSION['tipo_mensaje']);

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$carrera_filter = isset($_GET['carrera']) ? trim($_GET['carrera']) : '';
$localidad_filter = isset($_GET['localidad']) ? trim($_GET['localidad']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$where_clauses = ["1=1"];
$params = [];
$types = "";

if ($search !== '') {
    $where_clauses[] = "(nombre LIKE ? OR apellido LIKE ? OR email LIKE ? OR dni LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
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

$count_sql = "SELECT COUNT(*) as total FROM preinscripciones WHERE $where_sql";
$stmt = $conn->prepare($count_sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$total_items = $stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_items / $per_page);
$stmt->close();

$sql = "SELECT * FROM preinscripciones WHERE $where_sql ORDER BY creadoa DESC LIMIT ? OFFSET ?";
$params_with_pagination = $params;
$params_with_pagination[] = $per_page;
$params_with_pagination[] = $offset;
$types_with_pagination = $types . "ii";

$stmt = $conn->prepare($sql);
if (!empty($params_with_pagination)) {
    $stmt->bind_param($types_with_pagination, ...$params_with_pagination);
}
$stmt->execute();
$result = $stmt->get_result();

$carreras_result = $conn->query("SELECT id, nombre FROM carreras WHERE activa = 1 ORDER BY nombre");

$localidades = ['alberdi', 'aguilares', 'concepcion', 'graneros', 'lacocha', 'lamadrid', 'santana', 'villabel', 'otraloc'];
$localidades_nombres = [
    'alberdi' => 'Juan Bautista Alberdi',
    'aguilares' => 'Aguilares',
    'concepcion' => 'Concepción',
    'graneros' => 'Graneros',
    'lacocha' => 'La Cocha',
    'lamadrid' => 'La Madrid',
    'santana' => 'Santa Ana',
    'villabel' => 'Villa Belgrano',
    'otraloc' => 'Otro/a'
];

$carreras_nombres = [
    'alimentos' => 'Técnico Superior en Agroindustria de los Alimentos',
    'historia' => 'Profesorado de Educación Secundaria en Historia',
    'matematicas' => 'Profesorado de Educación Secundaria en Matemáticas',
    'agropecuaria' => 'Técnico Superior en Gestión de Producción Agropecuaria',
    'software' => 'Técnico Superior en Desarrollo de Software'
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IES La Cocha</title>
    <link rel="stylesheet" href="stylespanel.css">
    <style>
        /* Estilos adicionales para mejorar la visualización */
        .table-container {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table {
            width: 100%;
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            padding: 0.75rem 0.5rem;
            white-space: nowrap;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        
        .table td {
            padding: 0.75rem 0.5rem;
            vertical-align: middle;
            text-transform: uppercase;
        }
        
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.85rem;
            margin: 0.1rem;
            white-space: nowrap;
        }
        
        .form-control, .btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
        }
        
        .btn-warning {
            background-color: #ffc107;
            color: #000;
            border: none;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        
        .btn-light {
            background-color: #f8f9fa;
            color: #000;
            border: 1px solid #ddd;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 0.5rem;
        }
        
        .page-item .page-link {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
        }
        
        .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar-custom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="navbar-title">Dashboard</h3>
                    <small class="navbar-subtitle">IES La Cocha</small>
                </div>
                <div class="navbar-user">
                    <span>Bienvenido, <strong><?php echo htmlspecialchars($usuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-light btn-sm">Cerrar Sesión</a>
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Inscripciones</h2>
            <?php if ($user_rol === 'admin'): ?>
                <a href="crear_inscripcion.php" class="btn btn-primary">+ Nueva Inscripción</a>
            <?php endif; ?>
        </div>

        <div class="table-container mb-4">
            <form method="GET" action="" class="d-flex" style="gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
                <input type="text" name="search" class="form-control" style="flex: 2; min-width: 200px;"
                       placeholder="Buscar por nombre, apellido, email o DNI..." 
                       value="<?php echo htmlspecialchars($search); ?>">
                
                <select name="carrera" class="form-control" style="flex: 1; min-width: 200px;">
                    <option value="">Todas las carreras</option>
                    <?php 
                    foreach ($carreras_nombres as $valor => $nombre_completo): ?>
                        <option value="<?php echo htmlspecialchars($valor); ?>"
                                <?php echo $carrera_filter === $valor ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($nombre_completo); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="localidad" class="form-control" style="flex: 1; min-width: 150px;">
                    <option value="">Todas las localidades</option>
                    <?php foreach ($localidades as $loc): ?>
                        <option value="<?php echo htmlspecialchars($loc); ?>"
                                <?php echo $localidad_filter === $loc ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($localidades_nombres[$loc]); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="btn btn-secondary">Filtrar</button>
                <?php if ($search !== '' || $carrera_filter !== '' || $localidad_filter !== ''): ?>
                    <a href="paneldecontrol.php" class="btn btn-light">Limpiar</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-container">
            <p class="text-muted">Mostrando <?php echo $result->num_rows; ?> de <?php echo $total_items; ?> inscripciones</p>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>DNI</th>
                            <th>Genero</th>
                            <th>Localidad</th>
                            <th>Direccion</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Carrera</th>
                            <th>Fecha de Inscripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($row['dni']); ?></td>
                                    <td><?php echo htmlspecialchars($row['genero']); ?></td>
                                    <td><?php echo htmlspecialchars(isset($localidades_nombres[$row['localidad']]) ? $localidades_nombres[$row['localidad']] : $row['localidad']); ?></td>
                                    <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                                    <td style="text-transform: lowercase;"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                                    <td><?php echo htmlspecialchars(isset($carreras_nombres[$row['carrera']]) ? $carreras_nombres[$row['carrera']] : $row['carrera']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['creadoa'])); ?></td>
                                    <td style="white-space: nowrap;">
                                        <?php if ($user_rol === 'admin'): ?>
                                            <a href="editar_inscripcion.php?id=<?php echo $row['id']; ?>" 
                                               class="btn btn-warning btn-sm">Editar</a>
                                            <button onclick="confirmarEliminar(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?>')" 
                                                    class="btn btn-danger btn-sm">Eliminar</button>
                                        <?php else: ?>
                                            <span class="text-muted">Sin permisos</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center text-muted">No se encontraron inscripciones</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_pages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination" style="justify-content: center;">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&carrera=<?php echo urlencode($carrera_filter); ?>&localidad=<?php echo urlencode($localidad_filter); ?>">
                                    Anterior
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="page-item disabled">
                            <span class="page-link">Página <?php echo $page; ?> de <?php echo $total_pages; ?></span>
                        </li>
                        
                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&carrera=<?php echo urlencode($carrera_filter); ?>&localidad=<?php echo urlencode($localidad_filter); ?>">
                                    Siguiente
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function confirmarEliminar(id, nombre) {
            if (confirm('¿Estás seguro de que deseas eliminar la inscripción de "' + nombre + '"?')) {
                window.location.href = 'eliminar_inscripcion.php?id=' + id;
            }
        }
    </script>
</body>
</html>
<?php
$stmt->close();
?>
