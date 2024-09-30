<!DOCTYPE html>
<html>
<head>
  <title>System Administrator Dashboard</title>
<link rel="stylesheet" type="text/css" href="/public/assets/css/bootstrap.min.css">
<!-- Add other Nice Admin CSS files here -->


</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">System Administrator Dashboard</a>
    <!-- Add navigation items here -->
  </nav>

  <div class="container mt-4">
    <!-- User Management -->
    <section id="user-management">
      <h2>User Management</h2>
      <table class="table">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>E-Waste Generator</td>
            <td>Active</td>
            <td>
              <button class="btn btn-warning">Suspend</button>
              <button class="btn btn-danger">Delete</button>
            </td>
          </tr>
          <!-- Add more rows here -->
        </tbody>
      </table>
    </section>

    <!-- System Health & Maintenance -->
    <section id="system-health" class="mt-4">
      <h2>System Health & Maintenance</h2>
      <!-- You can integrate a monitoring tool or chart here -->
      <div id="system-health-chart">
        <!-- Chart will be rendered here -->
      </div>
    </section>

    <!-- Backup & Recovery -->
    <section id="backup-recovery" class="mt-4">
      <h2>Backup & Recovery</h2>
      <button class="btn btn-primary">Backup Now</button>
      <button class="btn btn-secondary">Restore Backup</button>
    </section>

    <!-- Add other components like Report Generation, User Support, etc. -->
  </div>

<!-- Add Nice Admin JS files here -->
<script src="/public/assets/js/bootstrap.min.js"></script>
<!-- Add other Nice Admin JS files here -->



</body>
</html>
