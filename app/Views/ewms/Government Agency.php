<!DOCTYPE html>
<html>
<head>
  <title>Government Agency Dashboard</title>
<link rel="stylesheet" type="text/css" href="/public/assets/css/bootstrap.min.css">
<!-- Add other Nice Admin CSS files here -->


</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Government Agency Dashboard</a>
    <!-- Add navigation items here -->
  </nav>

  <div class="container mt-4">
    <!-- User Registration Form -->
    <section id="user-registration">
      <h2>User Registration</h2>
      <form>
        <div class="form-group">
          <label for="agencyName">Agency Name</label>
          <input type="text" class="form-control" id="agencyName">
        </div>
        <!-- Add more form fields here -->
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </section>

    <!-- Report Generation -->
    <section id="report-generation" class="mt-4">
      <h2>Report Generation</h2>
      <!-- You can integrate a charting library like Chart.js here -->
      <div id="chart-container">
        <!-- Chart will be rendered here -->
      </div>
    </section>

    <!-- Licensing and Compliance -->
    <section id="licensing-compliance" class="mt-4">
      <h2>Licensing and Compliance</h2>
      <table class="table">
        <thead>
          <tr>
            <th>License ID</th>
            <th>Entity</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>12345</td>
            <td>Recycler Co.</td>
            <td>Active</td>
            <td><button class="btn btn-warning">Revoke</button></td>
          </tr>
          <!-- Add more rows here -->
        </tbody>
      </table>
    </section>

    <!-- Add other components like educational resources, notice distribution, etc. -->
  </div>

<!-- Add Nice Admin JS files here -->
<script src="/public/assets/js/bootstrap.min.js"></script>
<!-- Add other Nice Admin JS files here -->



</body>
</html>
