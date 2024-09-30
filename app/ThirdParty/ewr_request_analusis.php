<main id="main" class="main">
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="card-header" style="background-color: #B7E4C7; color: white;">
                <h5 class="card-title">E-Waste Recycling Efficiency Analysis: <?= $months[(int) $selectedMonth] ?> <?= $selectedYear ?></h5>
            </div>

            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/monthlyRecycling'); ?>" method="post">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="month" class="form-label">Select Month</label>
                            <select id="month" name="month" class="form-select">
                                <?php foreach ($months as $num => $name): ?>
                                    <option value="<?= $num ?>" <?= ($num == (int) $selectedMonth) ? 'selected' : ''; ?>><?= $name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="year" class="form-label">Select Year</label>
                            <select id="year" name="year" class="form-select">
                                <?php for ($y = $currentYear; $y >= 2000; $y--): ?>
                                    <option value="<?= $y ?>" <?= ($y == $selectedYear) ? 'selected' : ''; ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </form>
            </div>

            <div class="mt-4">
                <div class="card-body">
                    <p>Number of materials processed: <?= count($inventorySummary) ?></p>
                    <p>Ratio of Recovered vs. Disposal Material: 
                        <?= $recycledSummary['ratio'] ?? 'N/A' ?>
                    </p>

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
                            <?php foreach ($recycledSummary['details'] as $item): // Ensure this is the correct data structure ?>
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
