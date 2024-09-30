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
            ?>
            <div class="card-header" style="background-color: #B7E4C7; color: white;">
                <h5 class="card-title">Request Summary Report: <?= $months[(int) $selectedMonth] ?? 'Monthly' ?> <?= $selectedYear ?></h5>
            </div>

            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/EwrCollections'); ?>" method="post">
                    <div class="row mb-3">

                        <div class="col-md-4">
                            <label for="month" class="form-label">Select Month</label>
                            <select id="month" name="month" class="form-select" required>
                                <option value="">-- Select Month --</option>
                                <?php foreach ($months as $num => $name): ?>
                                    <option value="<?= $num ?>" <?= (isset($selectedMonth) && $selectedMonth == $num) ? 'selected' : ''; ?>><?= $name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="year" class="form-label">Select Year</label>
                            <select id="year" name="year" class="form-select" required>
                                <option value="">-- Select Year --</option>
                                <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                    <option value="<?= $y ?>" <?= (isset($selectedYear) && $selectedYear == $y) ? 'selected' : ''; ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                    <?php if (isset($selectedDistrict)): ?>
                        <a href="<?= base_url('sys/EwrCollections'); ?>" class="btn btn-secondary">Remove Filter</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="mt-4">
                <div class="card-body">
                    <h6>E-Waste Collections for Recycling:</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Area</th>
                                <th>Collected Listing Sets</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($collectionActivities)): ?>
                                <?php foreach ($collectionActivities as $activity): ?>
                                    <tr>
                                        <td><?= esc($activity['district'] ?? 'Unknown') ?></td>
                                        <td><?= esc($activity['count'] ?? 0) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">No data available. Please select both year and month.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
