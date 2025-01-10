<?php require_once 'views/templates/header.php'; ?>

<div class="container mt-4">
    <h1>Admin Dashboard</h1>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">View, edit, and delete user accounts.</p>
                    <a href="index.php?action=admin_manage_users" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Roles</h5>
                    <p class="card-text">Create, edit, and delete user roles.</p>
                    <a href="index.php?action=admin_manage_roles" class="btn btn-primary">Manage Roles</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Permissions</h5>
                    <p class="card-text">Assign and revoke permissions for roles.</p>
                    <a href="index.php?action=admin_manage_permissions" class="btn btn-primary">Manage Permissions</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Project Overview</h5>
                    <p class="card-text">View all projects and their statuses.</p>
                    <a href="index.php?action=admin_project_overview" class="btn btn-primary">Project Overview</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">System Logs</h5>
                    <p class="card-text">View system logs and activity.</p>
                    <a href="index.php?action=admin_system_logs" class="btn btn-primary">View Logs</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Admin Profile</h5>
                    <p class="card-text">View and update your admin profile.</p>
                    <a href="index.php?action=admin_profile" class="btn btn-primary">View Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/templates/footer.php'; ?>

