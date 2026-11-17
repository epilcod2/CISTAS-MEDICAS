<?php
// index.php
require_once 'db_config.php';
session_start();

$msg = "";
$msgType = "";

// Lógica de Login
if (isset($_POST['login'])) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
    $stmt->execute([$_POST['user'], $_POST['pass']]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['usuario'] = $user['usuario'];
    } else {
        $msg = "Acceso denegado. Verifique sus credenciales.";
        $msgType = "error";
    }
}

// Cerrar Sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Lógica de Registro de Cita
if (isset($_POST['agendar'])) {
    $sql = "INSERT INTO citas (paciente_nombre, especialidad, fecha, hora) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['paciente'], $_POST['especialidad'], $_POST['fecha'], $_POST['hora']]);
    $msg = "Cita registrada correctamente en la base de datos.";
    $msgType = "success";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Médico Pro | Gestión de Citas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="main-wrapper">
    <?php if (!isset($_SESSION['usuario'])): ?>
        <!-- VISTA DE INICIO DE SESIÓN -->
        <div class="card login-card">
            <div class="card-header">
                <div class="icon-badge">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                    </svg>
                </div>
                <h2>Portal Médico</h2>
                <p class="subtitle">Ingrese sus credenciales de acceso</p>
            </div>

            <?php if ($msg): ?>
                <div class="alert alert-<?= $msgType ?>"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <form method="POST" class="form-layout">
                <div class="form-group">
                    <label for="user">Usuario</label>
                    <input type="text" id="user" name="user" placeholder="Ej. admin" required autocomplete="username">
                </div>
                <div class="form-group">
                    <label for="pass">Contraseña</label>
                    <input type="password" id="pass" name="pass" placeholder="••••••••" required autocomplete="current-password">
                </div>
                <button type="submit" name="login" class="btn btn-primary">Iniciar Sesión</button>
            </form>
        </div>

    <?php else: ?>
        <!-- BARRA SUPERIOR -->
        <header class="top-bar">
            <div class="brand">
                <span class="brand-dot"></span>
                <h1>Panel de Gestión Clínica</h1>
            </div>
            <div class="user-controls">
                <span class="user-badge">Dr(a). <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong></span>
                <a href="?logout=1" class="btn-logout">Cerrar Sesión</a>
            </div>
        </header>

        <?php if ($msg): ?>
            <div id="alert-box" class="alert alert-<?= $msgType ?>">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <!-- CONTENIDO PRINCIPAL EN DOS COLUMNAS -->
        <div class="dashboard-grid">
            <!-- FORMULARIO DE REGISTRO -->
            <section class="card form-section">
                <div class="section-title">
                    <h2>Agendar Cita</h2>
                    <p class="subtitle">Complete los datos de la nueva consulta</p>
                </div>

                <form method="POST" class="form-layout">
                    <div class="form-group">
                        <label for="paciente">Nombre completo del paciente</label>
                        <input type="text" id="paciente" name="paciente" placeholder="Ej. Juan Pérez M." required>
                    </div>

                    <div class="form-group">
                        <label for="especialidad">Especialidad médica</label>
                        <select id="especialidad" name="especialidad">
                            <option value="Medicina General">Medicina General</option>
                            <option value="Pediatría">Pediatría</option>
                            <option value="Odontología">Odontología</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" id="fecha" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input type="time" id="hora" name="hora" required>
                        </div>
                    </div>

                    <button type="submit" name="agendar" class="btn btn-primary btn-save">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Guardar Cita
                    </button>
                </form>
            </section>

            <!-- TABLA DE REPORTES -->
            <section class="card table-section">
                <div class="table-header">
                    <h2>Citas Registradas</h2>
                    <span class="badge-info">Base de Datos Local</span>
                </div>

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Paciente</th>
                                <th>Especialidad</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM citas ORDER BY id DESC");
                            $hasRows = false;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                                $hasRows = true; ?>
                                <tr>
                                    <td class="td-id">#<?= $row['id'] ?></td>
                                    <td class="td-patient"><?= htmlspecialchars($row['paciente_nombre']) ?></td>
                                    <td><span class="pill"><?= htmlspecialchars($row['especialidad']) ?></span></td>
                                    <td class="td-date">
                                        <span class="date-badge"><?= htmlspecialchars($row['fecha']) ?></span>
                                    </td>
                                    <td class="td-time">
                                        <span class="time-badge"><?= htmlspecialchars($row['hora']) ?></span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            <?php if (!$hasRows): ?>
                                <tr>
                                    <td colspan="5" class="empty-state">No hay citas registradas en el sistema.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    <?php endif; ?>
</div>

<script>
    // Ocultar automáticamente la alerta de confirmación tras 4 segundos
    const alertBox = document.getElementById('alert-box');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 400);
        }, 4000);
    }
</script>

</body>
</html>