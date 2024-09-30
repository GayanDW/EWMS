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
            $selectedMonth = $selectedMonth ?? date('m'); // Assuming this comes from the controller
            $selectedYear = $selectedYear ?? date('Y'); // Assuming this comes from the controller
            ?>
            <div class="section-title">
                <h2>Collection Activity Analysis for <?= $months[(int) $selectedMonth] ?> <?= $selectedYear ?></h2>
            </div>

            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/collectionActivityAnalysis'); ?>" method="post">
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

            <!-- Displaying the Collection Activity Analysis -->
            <div class="card">
                <div class="card-header" style="background-color: #ffc107; color: white;">
                    <h5 class="card-title">Collection Activity Analysis: <?= $months[$selectedMonth] ?> <?= $selectedYear ?></h5>
                </div>
                <div class="card-body">
                    <p>Pickup Summary for <?= $months[$selectedMonth] ?> <?= $selectedYear ?>: <strong><?= count($collectionAnalysis['collections']) ?> Collected</strong></p>
                    <h5>Number of e-waste generators served: <strong><?= $collectionAnalysis['generatorsServed'] ?></strong></h5>


                    <h6>E-Waste Category Analysis:</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Number of Collections</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($collectionAnalysis['collections'] as $data): ?>
                                <tr>
                                    <td><?= esc($data['item_type']) ?></td>
                                    <td><?= esc($data['collections']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
