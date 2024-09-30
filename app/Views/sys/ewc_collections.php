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
                <h5 class="card-title">Monthly Collection Activity Analysis:  </h5>
            </div>
<!-- <?= $months[(int) $selectedMonth] ?? 'Annual' ?> <?= $selectedYear ?> -->
            <div class="container" data-aos="fade-up">
                <form action="<?= base_url('sys/ewcCollections'); ?>" method="post">
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

            <!-- Displaying the Collection Activity Analysis -->
            <div class="mt-4">

                <div class="card-body">
                    <div class="card-body">


                    </div>

                   
                    <!--  <p>Number of e-waste generators served: <?= esc($collectionsInfo['generatorsServed']) ?></p> -->
                    <h6>E-Waste Category Analysis:</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Number of Collections</th>
                                <!-- <th>Number of Items</th> -->
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($collectionsInfo['collections'] as $collection): ?>
                                <tr>
                                    <td><?= esc($collection['item_type']) ?></td>
                                    <td><?= esc($collection['collections']) ?></td>
                                    
                                     <!-- <td><?= esc($collection['totalquantity']) ?></td> -->
                                    
                                </tr>
                            <?php endforeach; ?>
                                <!--  <tr>
                                <th>Total Categories: <?= esc($collectionsInfo['totals']['totalCategories']) ?></th>
                                <th>Total Collections: <?= esc($collectionsInfo['totals']['totalCollections']) ?></th>
                                <th>Total Items: <?= esc($collectionsInfo['totals']['totalItems']) ?></th>
                            </tr> -->
                                
                           
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>
</main>
