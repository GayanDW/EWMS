<div class="container mt-4">
    <h2 class="mb-4">E-Waste Category Distribution Report</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filter Options</h5>
                    <form id="filterForm" action="<?= base_url('sys/eWasteCategoryDistributionReport') ?>" method="POST">
                        <div class="row">
                            <div class="col">
                                <label for="timeFrame">Time Frame:</label>
                                <select class="form-control" name="timeFrame" required>
                                    <option value="day">Last 1 Day</option>
                                    <option value="month">Last 1 Month</option>
                                    <option value="year">Last 1 Year</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="ewg">E-Waste Generator:</label>
                                <select class="form-control" name="ewg" required>
                                    <option value="all">All</option>
                                    <?php foreach ($eWasteGenerators as $generator): ?>
                                        <option value="<?= $generator['id']; ?>"><?= htmlspecialchars($generator['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Generate Report</button>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Report Results</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categoryQuantities as $categoryQuantity): ?>
                                <tr>
                                    <td><?= htmlspecialchars($categoryQuantity['category']); ?></td>
                                    <td><?= htmlspecialchars($categoryQuantity['quantity']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>