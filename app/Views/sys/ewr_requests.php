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
            <div class="card-header" style="background-color: #B7E4C; color: white;">
                <h5 class="card-title">Request Summary Report: <?= $months[(int) $selectedMonth] ?? 'Annual' ?> <?= $selectedYear ?></h5>
            </div>

            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/EwrRequests'); ?>" method="post">
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
                <?php if (!empty($requestSummary)): ?>
                    <h5 class="card-title">Request Summary for <?= $selectedMonth ? $months[(int) $selectedMonth] : 'Annual' ?> <?= $selectedYear ?></h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Request status</th>
                                <th>Request count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requestSummary as $status): ?>
                                <tr>
                                    <td><?= $status['req_status_c'] ?></td>
                                    <td><?= $status['count'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">No listings found for the selected month and year.</p>
                <?php endif; ?>
            </div>

            <!-- Display Rejection Reasons -->
             <!--  <div class="mt-4">
                <?php if (!empty($rejectionReasons) && is_array($rejectionReasons)): ?>
                    <h5 class="card-title">Rejection Reasons for <?= $selectedMonth ? $months[(int) $selectedMonth] : 'Annual' ?> <?= $selectedYear ?></h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rejection Reason</th>
                                <th>Rejection Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rejectionReasons as $reason): ?>
                                <tr>
                                    <td><?= $reason['rejection_reason'] ?></td>
                                    <td><?= $reason['count'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <h5 class="card-title">Rejection Reasons for <?= $selectedMonth ? $months[(int) $selectedMonth] : 'Annual' ?> <?= $selectedYear ?></h5>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rejection Reason</th>
                                <th>Rejection Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="2">No rejections for the selected month and year</td>
                            </tr>
                        </tbody>
                    </table>


                <?php endif; ?>

            </div> -->
           

        </div>
    </section>
</main>
