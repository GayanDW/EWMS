<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Add User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Register User</h5>
                <span class="text-success"><?= @$msg ?></span>
                <!-- Multi Columns Form -->
                <form action="/addUser" method="post">
                    <div class="row g-3">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName">
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="telNo" class="form-label">Tel. No.</label>
                            <input type="tel" class="form-control" id="telNo" name="telNo">
                        </div>
                        <!-- Location Information -->
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="District" class="form-label">District</label>
                            <select id="District" class="form-select" name="District">
                                <option value="" selected disabled>--Select District--</option>
                                <option value="Colombo">Colombo</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Matara">Matara</option>
                                <!-- Add more districts here -->
                            </select>
                        </div>
                        <!-- Role and Status -->
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" class="form-select" name="role">
                                <option value="systemAdministrator">System Administrator</option>
                                <option value="eWasteGenerator">E-waste Generator</option>
                                <option value="eWasteCollector">E-waste Collector</option>
                                <option value="eWasteRecycler">E-waste Recycler</option>
                                <option value="governmentAgency">Government Agency</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" class="form-select" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <!-- Submit and Reset Buttons -->
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-secondary" value="Reset">
                        </div>
                    </div><!-- End Multi Columns Form -->
                </form>
            </div>
        </div> 
    </section>
</main>
