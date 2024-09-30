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
                <h5 class="card-title">Monthly Income Report for: </h5>
            </div>
<!-- <?= $months[(int) $selectedMonth] ?? 'Select Month' ?> <?= $selectedYear ?> -->
            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/ewgIncome'); ?>" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="month" class="form-label">Select Month</label>
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

            <!-- Displaying the Income Report -->
            <?php if (!empty($incomeReport)): ?>
                <div class="mt-4">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Total Sales</th>
                                <th>Total Income (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($incomeReport as $report): ?>
                                <tr>
                                    <td><?= $report['year']; ?></td>
                                    <td><?= $months[$report['month']]; ?></td>
                                    <td><?= $report['totalListings']; ?></td>
                                    <td>Rs. <?= number_format($report['totalIncome'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif (isset($selectedMonth) && empty($incomeReport)): ?>
                <div class="text-center mt-4">
                    <p>No records were found for the selected month.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
