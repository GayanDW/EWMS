<main id="main" class="main">
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <?php
            $months = [
                1 => 'January', 2 => 'February', 3 => 'March',
                4 => 'April', 5 => 'May', 6 => 'June',
                7 => 'July', 8 => 'August', 9 => 'September',
                10 => 'October', 11 => 'November', 12 => 'December'
            ];
            $currentYear = date('Y');
            ?>
            <div class="card-header" style="background-color: #6fa8dc; color: white;">
                <h5 class="card-title">Listings Summary Report: <?= $months[(int) $selectedMonth] ?? 'Annual' ?> <?= $selectedYear ?></h5>
            </div>

            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/ewgListings'); ?>" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="month" class="form-label">Select Month (optional for yearly report)</label>

                            <select id="month" name="month" class="form-select">
                                <option value="">-- Select Month --</option>
                                <?php foreach ($months as $num => $name): ?>
                                    <option value="<?= $num ?>" <?= (isset($selectedMonth) && $selectedMonth == $num) ? 'selected' : ''; ?>><?= $name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="year" class="form-label">Select Year</label>
                            <select id="year" name="year" class="form-select">
                                <?php for ($y = $currentYear; $y >= 2020; $y--): ?>
                                    <option value="<?= $y ?>" <?= (isset($selectedYear) && $selectedYear == $y) ? 'selected' : ''; ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </form>
            </div>

            <div class="mt-4">
                <?php if (!empty($listings)): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Number of Listings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listings as $listing): ?>
                                <tr>
                                    <td><?= $listing['item_type'] ?></td>
                                    <td><?= $listing['nooflist'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p><center>No listings found for the selected month and year.</center></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <h3>Listing Status Insights</h3>
            <?php if ($summary['totalListed'] == 0 && $summary['active'] == 0 && $summary['soldOut'] == 0 && $summary['deleted'] == 0): ?>
                <p><center>No Listing Status Insights found for the selected month and year.</center></p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Status</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Listed</td>
                                <td><?= $summary['totalListed'] ?? '0'; ?></td>
                            </tr>
                            <tr>
                                <td>Active (Not Sold Out or Not Deleted)</td>
                                <td><?= $summary['active'] ?? '0'; ?></td>
                            </tr>
                            <tr>
                                <td>Sold Out</td>
                                <td><?= $summary['soldOut'] ?? '0'; ?></td>
                            </tr>
                            <tr>
                                <td>Deleted</td>
                                <td><?= $summary['deleted'] ?? '0'; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Add this button/link wherever appropriate in your view file -->
    <a href="<?= base_url('sys/export_monthly_report') ?>" class="btn btn-primary">Export to CSV</a>

    <a href="<?= base_url('sys/export_monthly_report_pdf') ?>" class="btn btn-primary">Export to PDF</a>



</main>
