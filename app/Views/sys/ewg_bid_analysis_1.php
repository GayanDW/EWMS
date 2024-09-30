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


            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/ewgBids'); ?>" method="post">
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
                                <option value="">-- Select Year --</option>
                                <?php for ($y = $currentYear; $y >= 2020; $y--): ?>
                                    <option value="<?= $y ?>" <?= (isset($selectedYear) && $selectedYear == $y) ? 'selected' : ''; ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </form>
            </div>
            <div class="container" id="report0">
                <div class="card-header" style="background-color: #6fa8dc; color: white;">
                    <h5 class="card-title">Monthly Bid Summary Report: </h5>
                </div>
<!-- <?= $months[(int) $selectedMonth] ?? 'Annual' ?> <?= $selectedYear ?> -->

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Status</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example of dynamic content -->
                            <?php if (!empty($bidSummary)): ?>
                                <?php foreach ($bidSummary as $status): ?>
                                    <tr>
                                        <td><?= $status['bid_status_g'] ?></td>
                                        <td><?= $status['count'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">No bid data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>


            </div>

    </section>
</div>
</main>
