<!DOCTYPE html>
<html>
<head>
  <title>E-Waste Recycler Dashboard</title>
<link rel="stylesheet" type="text/css" href="/public/assets/css/bootstrap.min.css">
<!-- Add other Nice Admin CSS files here -->


</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">E-Waste Recycler Dashboard</a>
    <!-- Add navigation items here -->
  </nav>

  <div class="container mt-4">
    <!-- User Registration Form -->
    <section id="user-registration">
      <h2>User Registration</h2>
      <form>
        <div class="form-group">
          <label for="businessName">Business Name</label>
          <input type="text" class="form-control" id="businessName">
        </div>
        <!-- Add more form fields here -->
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </section>

    <!-- Inventory Review Table -->
    <section id="inventory-review" class="mt-4">
      <h2>Inventory Review</h2>
      <table class="table">
        <thead>
          <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Smart TV</td>
            <td>Samsung 55-inch</td>
            <td>Recycled</td>
          </tr>
          <!-- Add more rows here -->
        </tbody>
      </table>
    </section>

    <!-- Report Generation -->
    <section id="report-generation" class="mt-4">
      <h2>Report Generation</h2>
      <!-- You can integrate a charting library like Chart.js here -->
      <div id="chart-container">
        <!-- Chart will be rendered here -->
      </div>
    </section>

    <!-- Add other components like communication, feedback, etc. -->
  </div>

<!-- Add Nice Admin JS files here -->
<script src="/public/assets/js/bootstrap.min.js"></script>
<!-- Add other Nice Admin JS files here -->



</body>
</html>
