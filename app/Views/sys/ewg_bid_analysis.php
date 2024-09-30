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
                <h5 class="card-title">Bid Summary Report: <?= $months[(int) $selectedMonth] ?? 'Annual' ?> <?= $selectedYear ?></h5>
            </div>

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
                                <?php for ($y = $currentYear; $y >= 2020; $y--): ?>
                                    <option value="<?= $y ?>" <?= (isset($selectedYear) && $selectedYear == $y) ? 'selected' : ''; ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </form>
            </div>

            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Bid Summary</h3>
                            <ul class="list-group list-group-flush">
                                <!-- Bid Summary -->
                                <?php if (!empty($bidSummary)): ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($bidSummary as $status): ?>
                                            <li><?= $status['bid_status_g'] ?> Bids: <?= $status['count'] ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <li>No bid data available</li>
                                <?php endif; ?>

                                <!-- Rejection Reasons -->
                                <h5 class="card-title">Rejected Reasons</h5>
                                <?php if (!empty($rejectionReasons)): ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($rejectionReasons as $reason): ?>
                                            <li><?= $reason['rejection_reason'] ?>: <?= $reason['count'] ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <li>No rejection data available</li>
                                <?php endif; ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Bid Summary</h3>
                            <ul class="list-group list-group-flush">
                                <!-- Dynamically insert bid status summary here -->
                                <?php if (!empty($bidSummary)): ?>
                                    <li class="list-group-item">Received Bids: <strong><?= htmlspecialchars($bidSummary['Received Bids'] ?? '0') ?></strong></li>
                                    <li class="list-group-item">Accepted Bids: <strong><?= htmlspecialchars(($bidSummary['Accepted'] ?? '0') + ($bidSummary['Cancelled'] ?? '0')) ?></strong></li>
                                    <li class="list-group-item">Pending Bids: <strong><?= htmlspecialchars($bidSummary['Pending Bids'] ?? '0') ?></strong></li>
                                    <li class="list-group-item">Withdrawn Bids: <strong><?= htmlspecialchars($bidSummary['Withdrawn'] ?? '0') ?></strong></li>
                                    <li class="list-group-item">Rejected Bids: <strong><?= htmlspecialchars($bidSummary['Rejected'] ?? '0') ?></strong></li>
                                    <li class="list-group-item">Cancelled after Accept: <strong><?= htmlspecialchars($bidSummary['Cancelled'] ?? '0') ?></strong></li>
                                <?php else: ?>
                                    <li class="list-group-item">No bid data available</li>
                                <?php endif; ?>

                                <h5 class="card-title mt-4">Rejected Reasons</h5>
                                <!-- Dynamically insert rejection reasons here -->
                                <?php if (!empty($rejectionReasons)): ?>
                                    <li class="list-group-item">Low Bid Amount: <strong><?= htmlspecialchars($rejectionReasons['Low Bid Amount'] ?? '0') ?></strong></li>
                                    <li class="list-group-item">Schedule Issues: <strong><?= htmlspecialchars($rejectionReasons['Schedule Issues'] ?? '0') ?></strong></li>
                                    <li class="list-group-item">Other Reasons: <strong><?= htmlspecialchars($rejectionReasons['Other Reasons'] ?? '0') ?></strong></li>
                                <?php else: ?>
                                    <li class="list-group-item">No rejection data available</li>
                                    <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </section>
</main>
