<?php
$this->title = 'Dashboard - Facturacheck Admin';
?>

<div class="stats">
    <div class="stat-card">
        <h3>Cuentas Activas</h3>
        <div class="value">0</div>
    </div>
    <div class="stat-card">
        <h3>Usuarios Total</h3>
        <div class="value">0</div>
    </div>
    <div class="stat-card">
        <h3>Documentos Hoy</h3>
        <div class="value">0</div>
    </div>
    <div class="stat-card">
        <h3>Facturas Enviadas</h3>
        <div class="value">0</div>
    </div>
</div>

<div class="card">
    <h2 style="margin-bottom: 1rem; color: #2c3e50;">Bienvenido al Panel de Administración</h2>
    <p style="color: #7f8c8d; margin-bottom: 1.5rem;">
        Gestione cuentas, usuarios y documentos de facturación electrónica con Verifactu.
    </p>

    <h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #2c3e50;">Acciones Rápidas</h3>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="/admin/account/create" class="btn">Nueva Cuenta</a>
        <a href="/admin/user/create" class="btn">Nuevo Usuario</a>
        <a href="/admin/document" class="btn">Ver Documentos</a>
    </div>

    <h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #2c3e50;">Estado del Sistema</h3>
    <ul style="list-style: none; padding: 0;">
        <li style="padding: 0.5rem 0; border-bottom: 1px solid #ecf0f1;">
            <strong>Base de Datos:</strong> <span style="color: #27ae60;">✓ Conectada</span>
        </li>
        <li style="padding: 0.5rem 0; border-bottom: 1px solid #ecf0f1;">
            <strong>Redis Cache:</strong> <span style="color: #27ae60;">✓ Activo</span>
        </li>
        <li style="padding: 0.5rem 0; border-bottom: 1px solid #ecf0f1;">
            <strong>Queue System:</strong> <span style="color: #27ae60;">✓ Operativo</span>
        </li>
        <li style="padding: 0.5rem 0;">
            <strong>Verifactu API:</strong> <span style="color: #f39c12;">⚠ No configurada</span>
        </li>
    </ul>
</div>
