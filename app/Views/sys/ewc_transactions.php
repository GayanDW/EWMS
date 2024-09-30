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
            <div class="card-header" style="background-color: #ffc107;  color: white;">
                <h5 class="card-title">Monthly Transaction Activity Analysis:  </h5>
            </div>
<!-- <?= $months[(int) $selectedMonth] ?? 'Annual' ?> <?= $selectedYear ?> -->
            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/ewcTransactions'); ?>" method="post">
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


            <!-- Displaying the Transaction Activity Analysis -->
            <div class="mt-4">
                <div class="card-body">
                    <p>Number of Transactions Processed: <?= esc($transactions[0]['tcount'] ?? 0) ?></p>
                    <h6>Transaction Summary:</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Total Payment</th>
                                <!-- <th>Transaction Count</th> -->
                                
                                <!-- <th>Cash Payment</th> -->
                                
                                <!-- <th>Bank Payment</th> -->
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transactionAnalysis['methods'])): ?>
                                <?php foreach ($transactionAnalysis['methods'] as $method): ?>
                                    <tr>
                                        <td><?= esc($method['Category'] ?? 'N/A') ?></td>
                                        <td><?= esc($method['Total_Payment'] ?? '0.00') ?></td>
                                        <!-- <td><?= esc($method['tcCount'] ?? '0.00') ?></td> -->
                                        
                                        <!-- <td><?= esc($method['Cash_Payment'] ?? '0.00') ?></td> -->
                                        
                                        <!-- <td><?= esc($method['Bank_Payment'] ?? '0.00') ?></td> -->
                                                                               
                                        
                                    </tr>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <tr><td colspan="4">No transaction data found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
