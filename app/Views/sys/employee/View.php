<main id="main" class="main">

    <div class="pagetitle">
        <h1>Employee</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Employee</a></li>
                <li class="breadcrumb-item active">View</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Search Employee</h5>
                <span class="text-success"><?= @$msg ?></span>
                <!-- Multi Columns Form -->
                <?= form_open('employee/view') ?>
                <div class="row g-3">
                             
                    <div class="col-md-6">
                        <label for="District" class="form-label">District</label>
                        <select id="District" class="form-select" name="District">
                            <option>--</option>
                            <option value="Colombo" <?php  if(set_value('District')=='Colombo')  { echo 'selected'; }  ?>  >Colombo</option>
                            <option value="Kandy" <?php  if(set_value('District')=='Kandy')  { echo 'selected'; }  ?>>Kandy</option>
                            <option value="Matara" <?php  if(set_value('District')=='Matara')  { echo 'selected'; }  ?>>Matara</option>
                        </select>
                    </div>
                    
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div><!-- End Multi Columns Form -->
                <?= form_close() ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Default Table</h5>

                <!-- Default Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Tel.No.</th>
                            <th scope="col">Email</th>
                            <th scope="col">DOB</th>
                            <th scope="col">District</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php 
                         $i=1;
                        foreach ($list as $key => $result) { ?>
                        
                            <tr>
                                <th scope='row'><?=$i?></th>
                                <td><?= $result['FirstName'] ?> <?= $result['LastName'] ?></td>
                                <td><?= $result['Address'] ?></td>
                                <td><?= $result['TelNo'] ?></td>
                                <td><?= $result['Email'] ?></td>
                                <td><?= $result['DOB'] ?></td>
                                <td><?= $result['District'] ?></td>
                            </tr>
                        <?php
                        $i++;
                        
                        } ?>
                            
                            

                    </tbody>
                </table>
                <!-- End Default Table Example -->
            </div>
        </div>
    </section>


</main>
