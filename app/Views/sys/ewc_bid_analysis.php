<main id="main" class="main">
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <?php
            // Pre-define month names and the current year for dropdowns
            $months = [
                1 => 'January', 2 => 'February', 3 => 'March',
                4 => 'April', 5 => 'May', 6 => 'June',
                7 => 'July', 8 => 'August', 9 => 'September',
                10 => 'October', 11 => 'November', 12 => 'December'
            ];
            $currentYear = date('Y');

            // Display selected month and year or placeholders
            $monthName = isset($selectedMonth) ? $months[(int) $selectedMonth] : '--';
            $yearDisplay = $selectedYear ?? '--';
            ?>

            <div class="card-header" style="background-color: #6fa8dc; color: white;">
                
            </div>

            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/ewcBidAnalysis'); ?>" method="post">
                    <div class="row mb-3">
                        <!-- Month selection -->
                        <div class="col">
                            <label for="month" class="form-label">Select Month</label>
                            <select id="month" name="month" class="form-select">
                                <?php foreach ($months as $num => $name): ?>
                                    <option value="<?= $num ?>" <?= ($num == (int) @$selectedMonth) ? 'selected' : ''; ?>><?= $name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Year selection -->
                        <div class="col">
                            <label for="year" class="form-label">Select Year</label>
                            <select id="year" name="year" class="form-select">
                                <?php for ($y = $currentYear; $y >= 2000; $y--): ?>
                                    <option value="<?= $y ?>" <?= ($y == @$selectedYear) ? 'selected' : ''; ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
            <!-- Placeholder for Displaying listings -->
            <div class="mt-4">
                <?php if (isset($bidSummary) && !empty($bidSummary)): ?>
                    <table class="table table-striped" >
                        <thead>
                            <tr>
                                <th>Bid Status</th>
                                <th>Number of Bids</th>
                            </tr>


                        </thead>

                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($bidSummary as $key => $value) {
                                $total += $value['total'];
                                ?>
                                <tr>
                                    <td><?= $value['bid_status_c'] ?></td>
                                    <td><?= $value['total'] ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>Total</td>
                                <td><?= $total ?></td>
                            </tr>

                        </tbody>
                    </table>



                    <p>Listing data will be displayed here.</p>
                <?php else: ?>
                    <p>No listings found for the selected month and year.</p>
                <?php endif; ?>

                <!-- Listing Status Insights (Example Placeholder) -->
                <!-- Ensure your controller method fetches and provides similar structured data -->
                <div class="mt-5">
                    <h3>Listing Status Insights</h3>
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
                                    <td>Sold Out </td>
                                    <td><?= $summary['soldOut'] ?? '0'; ?></td>
                                </tr>
                                <tr>
                                    <td>Deleted</td>
                                    <td><?= $summary['deleted'] ?? '0'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
