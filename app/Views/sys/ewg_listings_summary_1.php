
<main id="main" class="main">
    <section id="contact" class="contact">

        <div class="container" data-aos="fade-up"  >
            <?php
            $months = [
                1 => 'January', 2 => 'February', 3 => 'March',
                4 => 'April', 5 => 'May', 6 => 'June',
                7 => 'July', 8 => 'August', 9 => 'September',
                10 => 'October', 11 => 'November', 12 => 'December'
            ];
            $currentYear = date('Y');
            ?>

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
            <!-- report 0 -->
            <div class="mt-4" id="report0">
                
                <div class="card-header" style="background-color: #6fa8dc; color: white;">
                    <h5 class="card-title">Monthly Listings Summary Report: </h5>
                </div>
                <!-- <?= $months[(int) $selectedMonth] ?? 'Annual' ?> <?= $selectedYear ?></h5> -->
                
                
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
        <!-- end report 0 -->


    </section>

   

    <!-- Add this button/link wherever appropriate in your view file -->
    <!--<a href="<?= base_url('sys/export_monthly_report') ?>" class="btn btn-primary">Export to CSV</a>-->

   <!--< <a href="<?= base_url('sys/export_monthly_report_pdf') ?>" class="btn btn-primary">Export to PDF</a>-->



</main>



