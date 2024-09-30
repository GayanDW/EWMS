<main id="main" class="main">
    <div class="pagetitle">
        <h1></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(''); ?>">Home</a></li>
                <li class="breadcrumb-item active"></li>
            </ol>
        </nav>
    </div>


<div class="container mt-5">

    <h2>Requests for Listing Set <?= esc($listingSet) ?></h2>
    <div class="card recent-sales overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Request Details <span>| Listing Set <?= esc($listingSet) ?></span></h5>
            <table class="table datatable datatable-table">
                <thead>
                    <tr>
                        
                        <th>Requester Name</th>
                        <th>Preferred Day</th>
                        <th>Alternative Day</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $request): ?>
                        <tr>
                            <td><?= esc($request['businessName']) ?></td>
                            <td><?= esc($request['pref_day']) ?></td>
                            <td><?= esc($request['alt_day1']) ?></td>
                            <td><?= esc($request['req_status_r']) ?></td>
                            <td>
                                <?php if ($isAccepted): ?>
                                    <span class="badge bg-success">Accepted</span>
                                <?php else: ?>
                                    <!-- Accept Action -->
                                    <form action="<?= base_url('sys/ReqRespond') ?>" method="post">
                                        <input type="hidden" name="requestId" value="<?= $request['ewr_req_id'] ?>">
                                        <input type="hidden" name="listing_set" value="<?= $request['listing_set'] ?>">
                                        
                                        <div>
                                            <input type="radio" id="accept_pref_day_<?= $request['ewr_req_id'] ?>" name="accept_action" value="pref_day">
                                            <label for="accept_pref_day_<?= $request['ewr_req_id'] ?>">Preferred Day</label><br>
                                            <input type="radio" id="accept_alt_day_<?= $request['ewr_req_id'] ?>" name="accept_action" value="alt_day">
                                            
                                            
                                            <label for="accept_alt_day_<?= $request['ewr_req_id'] ?>">Alternative Day</label><br>
                                            <button type="submit" name="action" value="accept" class="btn btn-success">Accept</button>
                                        </div>
                                    </form>

                                    <!-- Reject Action -->
                                    <form action="<?= base_url('sys/ReqRespond') ?>" method="post">
                                        <input type="hidden" name="requestId" value="<?= $request['ewr_req_id'] ?>">
                                        <div>
                                            <input type="radio" id="reject_schedule_<?= $request['ewr_req_id'] ?>" name="reject_reason" value="Schedule">
                                            <label for="reject_schedule_<?= $request['ewr_req_id'] ?>">Schedule</label><br>
                                            <input type="radio" id="reject_price_<?= $request['ewr_req_id'] ?>" name="reject_reason" value="Price">
                                            <label for="reject_price_<?= $request['ewr_req_id'] ?>">Bid Price</label><br>
                                            <input type="radio" id="reject_other_<?= $request['ewr_req_id'] ?>" name="reject_reason" value="Other">
                                            <label for="reject_other_<?= $request['ewr_req_id'] ?>">Other</label><br>
                                            <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
