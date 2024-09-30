<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('sys/dashboard'); ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- View Inventory Nav -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('sys/ViewEwcInventory'); ?>">
                <i class="bi bi-card-list"></i>
                <span>View Inventory</span>
            </a>
        </li>

        <!-- E-waste Listings with submenu for Add New E-waste -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#e-waste-nav" data-bs-toggle="collapse" href="#" aria-expanded="false" >
                <i class="bi bi-list-check"></i>
                <span>E-waste Listings</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="e-waste-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= base_url('sys/viewEwcListings'); ?>">
                        <i class="bi bi-plus-circle"></i>
                        <span>View Listings</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('sys/listToEwcInventory'); ?>"> 
                        <i class="bi bi-plus-circle"></i>
                        <span>List E-waste Set</span>
                    </a>
                </li>

            </ul>
        </li>
        

        

        <!-- View Listings Nav -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('sys/viewEwcListings'); ?>">
                <i class="bi bi-wallet2"></i>
                <span>View Listings</span>
            </a>
        </li>




        <!-- Report Generation -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('sys/view_reports'); ?>" >
                <i class="bi bi-file-earmark-text"></i>
                <span>Report Generation</span>
            </a>
        </li>





        <!-- Notification  -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('sys/listByEwc'); ?>">
                <i class="bi bi-bell"></i>
                <span>List Items</span>
            </a>
        </li>



        <!-- Notification  -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('sys/viewEwcListings'); ?>">
                <i class="bi bi-bell"></i>
                <span>View My Listings</span>
            </a>
        </li>


        
        
        
    </ul>
</aside>




