<?php
session_start();
require ".ht_conexao-bd.php";

// SEGURANÇA: Só permite entrar se for administrador (tipo 0)
if (!isset($_SESSION["id_tipos_utilizador"]) || $_SESSION["id_tipos_utilizador"] != 0) {
    header("Location: indexeng.php");
    exit();
}

/* ======================================================
   QUERIES PARA O DASHBOARD (SIMPLIFICADO)
   ====================================================== */

// 1. Total de Utilizadores Registados
$res_users = mysqli_query($conexao, "SELECT COUNT(*) as total FROM utilizadores");
$total_users = mysqli_fetch_assoc($res_users)['total'];

// 2. Número de Vendas (Dinâmico com base nos carrinhos pagos)
$res_vendas = mysqli_query($conexao, "SELECT COUNT(*) as total FROM carrinho WHERE estado = 1");
$total_vendas = mysqli_fetch_assoc($res_vendas)['total'];

// 3. Lista de Últimos Utilizadores Registados
$lista_users = mysqli_query($conexao, "SELECT utilizador, email, estado_conta FROM utilizadores ORDER BY id_utilizadores DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - URBÆ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="URBAE COMPLETO.png">

    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; margin: 0; display: flex; }
        
        .admin-sidebar { width: 250px; background: #111; height: 100vh; color: #fff; padding: 30px 20px; position: fixed; }
        .admin-sidebar h2 { font-size: 20px; letter-spacing: 3px; border-bottom: 1px solid #333; padding-bottom: 20px; text-transform: uppercase; }
        .admin-sidebar nav { margin-top: 20px; }
        .admin-sidebar a { color: #888; text-decoration: none; display: block; padding: 12px 0; transition: 0.3s; }
        .admin-sidebar a:hover { color: #fff; padding-left: 10px; }

        .admin-main { margin-left: 250px; padding: 40px; width: calc(100% - 250px); }
        
        /* Grid com 2 colunas apenas */
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .stat-card i { font-size: 30px; color: #111; margin-bottom: 10px; }
        .stat-card h3 { margin: 0; font-size: 14px; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .stat-card p { margin: 5px 0 0; font-size: 28px; font-weight: 700; color: #111; }

        .admin-section { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .admin-section h2 { font-size: 18px; margin-bottom: 20px; color: #111; border-left: 4px solid #111; padding-left: 15px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 13px; color: #888; border-bottom: 1px solid #eee; padding: 12px; text-transform: uppercase; }
        td { padding: 15px 12px; font-size: 14px; border-bottom: 1px solid #f9f9f9; color: #444; }
        
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .badge-success { background: #e6f4ea; color: #1e7e34; }
        .badge-warning { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>

    <aside class="admin-sidebar">
        <h2>URBÆ ADMIN</h2>
        <nav>
            <a href="admineng.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="editar-utilizadoreseng.php"><i class="fas fa-users"></i> Users</a>
            <a href="indexeng.php"><i class="fas fa-arrow-left"></i> Back to Store</a>
            <a href="logout.php" style="margin-top:50px; color:#ff4d4d;"><i class="fas fa-sign-out-alt"></i> End Session</a>
        </nav>
    </aside>

    <main class="admin-main">
        <h1>Control Panel</h1>
        <p style="color: #666; margin-bottom: 40px;">Welcome, Administrator. Focused summary on users and sales.</p>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3>Registered Clients</h3>
                <p><?= $total_users ?></p>
            </div>
            <div class="stat-card">
                <i class="fas fa-shopping-cart"></i>
                <h3>Completed Sales</h3>
                <p><?= $total_vendas ?></p>
            </div>
        </div>

        <div class="admin-section">
            <h2>Latest Registered Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email Address</th>
                        <th>Account Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($lista_users) > 0): ?>
                        <?php while($u = mysqli_fetch_assoc($lista_users)): ?>
                        <tr>
                            <td><strong><?= $u['utilizador'] ?></strong></td>
                            <td><?= $u['email'] ?></td>
                            <td>
                                <span class="badge <?= $u['estado_conta'] == 1 ? 'badge-success' : 'badge-warning' ?>">
                                    <?= $u['estado_conta'] == 1 ? 'Ativo' : 'Pendente' ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3">No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>