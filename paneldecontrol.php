<?php
session_start();
require 'conect.php';
 

$usuario = $_SESSION['usuario'];
$user_rol = $_SESSION['rol'];

$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
$tipo_mensaje = isset($_SESSION['tipo_mensaje']) ? $_SESSION['tipo_mensaje'] : '';
unset($_SESSION['mensaje']);
unset($_SESSION['tipo_mensaje']);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;


// Contar total de registros
$count_sql = "SELECT COUNT(*) as total FROM preinscripciones";
$stmt = $conn->prepare($count_sql);
$stmt->execute();
$total_items = $stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_items / $per_page);
$stmt->close();

$sql = "SELECT * FROM preinscripciones ORDER BY creadoa DESC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IES La Cocha</title>
  <link rel="stylesheet" href="stylespanel.css">
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

         Eliminado formulario de filtros 

        <div class="table-container">
            <p class="text-muted">Mostrando <?php echo $result->num_rows; ?> de <?php echo $total_items; ?> inscripciones</p>
            
            <div style="overflow-x: auto;">
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
                                    <td><?php echo htmlspecialchars($row['localidad']); ?></td>
                                    <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                                    <td><?php echo htmlspecialchars($row['carrera']); ?></td>
                                       <td><?php echo date('d/m/Y H:i', strtotime($row['creadoa'])); ?></td>
                                    <td>
                                    </td>
                                    <td>
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
                                <td colspan="9" class="text-center text-muted">No se encontraron inscripciones</td>
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
                                 Eliminados parámetros de filtro de la paginación 
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                                    Anterior
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="page-item disabled">
                            <span class="page-link">Página <?php echo $page; ?> de <?php echo $total_pages; ?></span>
                        </li>
                        
                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                 Eliminados parámetros de filtro de la paginación 
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>">
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