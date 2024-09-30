<div class="container mt-5">
    <?php if (empty($requests)): ?>
        <p>You have not made a request for this listing set.</p>
    <?php else: ?>
        <?php foreach ($requests as $request): ?>
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        Request ID: <?= esc($request['ewr_req_id']) ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Details for Listing Set: <?= esc($request['listing_set']) ?></h5>
                        <p>Your Note: <?= esc($request['your_note']) ?></p>
                        <p>Preferred Day: <?= esc($request['pref_day']) ?>, Time Slot: <?= esc($request['slot_start']) ?> to <?= esc($request['slot_end']) ?></p>
                        <p>Alternative Day: <?= esc($request['alt_day1']) ?>, Time Slot: <?= esc($request['alt_start1']) ?> to <?= esc($request['alt_end1']) ?></p>
                        <p>Payment Method: <?= esc($request['payment_method']) ?></p>
                        <p>Status: <?= esc($request['req_status_r']) ?><?= $request['rejection_reason'] ? ', Reason: ' . esc($request['rejection_reason']) : '' ?></p>

                        <?php if ($request['payment_method'] == 'bank_transfer' && $request['req_status_r'] == 'accepted'): ?>
                            <h2>Upload Bank Slip</h2>
                            <form action="<?= base_url('sys/updateEwrInv/' . $request['ewr_req_id']) ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="bank_slip">Bank Slip:</label>
                                    <input type="file" class="form-control-file" id="bank_slip" name="bank_slip" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Inventory</button>
                            </form>

                            <?php if (isset($request['collectorDetails'])): ?>
                                <div class="info-section mt-4">
                                    <h2>Collector's Bank Information</h2>
                                    <ul>
                                        <?php if (!empty($request['collectorDetails']['BankName'])): ?>
                                            <li><strong>Bank Name:</strong> <?= esc($request['collectorDetails']['BankName']) ?></li>
                                        <?php endif; ?>
                                        <?php if (!empty($request['collectorDetails']['AccountName'])): ?>
                                            <li><strong>Account Name:</strong> <?= esc($request['collectorDetails']['AccountName']) ?></li>
                                        <?php endif; ?>
                                        <?php if (!empty($request['collectorDetails']['AccountNumber'])): ?>
                                            <li><strong>Account Number:</strong> <?= esc($request['collectorDetails']['AccountNumber']) ?></li>
                                        <?php endif; ?>
                                        <?php if (!empty($request['collectorDetails']['BranchName'])): ?>
                                            <li><strong>Branch Name:</strong> <?= esc($request['collectorDetails']['BranchName']) ?></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        <?php elseif ($request['payment_method'] == 'cash' && $request['req_status_r'] == 'accepted'): ?>
                            <p>You should pay at the time you collect.</p>
                        <?php endif; ?>

                        <a href="<?= base_url('sys/withdrawReq/' . $request['ewr_req_id']) ?>" class="btn btn-warning mt-3">Withdraw Request</a>
                        <a href="<?= base_url('sys/cancelDeal/' . $request['ewr_req_id']) ?>" class="btn btn-warning mt-3">Cancel Deal</a>
                        <a href="<?= base_url('sys/feedback/' . $request['ewr_req_id']) ?>" class="btn btn-info mt-3">Feedback</a>
                        <a href="<?= base_url('sys/updateEwrInv/' . $request['listing_set']) ?>" class="btn btn-primary mt-3">Collect</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
