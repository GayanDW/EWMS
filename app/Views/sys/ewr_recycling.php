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
            <div class="card-header" style="background-color:  #B7E4C7; color: white;">
                <h5 class="card-title">E-Waste Recycling Efficiency Analysis: <?= $months[(int) $selectedMonth] ?? 'Annual' ?> <?= $selectedYear ?></h5>
            </div>

            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/EwrRecycling'); ?>" method="post">
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


            <!-- Displaying the E-Waste Recycling Efficiency Analysis -->
            <div class="mt-4">
                <div class="card-body">
                    <!-- Replace this section with dynamic data -->
                    <p>Number of materials processed: <?= $inventorySummary['count'] ?? '0' ?></p>
                    <p>Ratio of Recovered vs. Disposal Material: <?= $recycledSummary['ratio'] ?? 'N/A' ?></p>

                    <h6>Material Type Analysis:</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Batch Number</th>
                                <th>Material Type</th>
                                <th>Material</th>
                                <th>Generated Mass (kg)</th>
                                <th>Recycled At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recycledSummary as $item): ?>
                                <tr>
                                    <td><?= esc($item['batch_id']) ?></td>
                                    <td><?= esc($item['Material_Type']) ?></td>
                                    <td><?= esc($item['Material']) ?></td>
                                    <td><?= esc($item['total_mass']) ?></td>
                                    <td><?= esc(date("F Y", strtotime($item['recycled_at']))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
