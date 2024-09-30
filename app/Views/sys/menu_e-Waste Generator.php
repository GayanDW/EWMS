<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('sys/dashboard') ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('sys/viewAddEwaste'); ?>">
                <i class="bi bi-grid"></i>
                <span>List E-waste</span>
            </a>
        </li>

        <!-- Report Generation -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('sys/view_reports'); ?>">
                <i class="bi bi-file-earmark-text"></i>
                <span>Reports</span>
            </a>
        </li>  

        <!-- Notification  -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('sys/viewCollected'); ?>">
                <i class="bi bi-bell"></i>
                <span>View My Sold Items</span>
            </a>
        </li>
              <!-- Notification  -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('sys/viewCollected1'); ?>">
                <i class="bi bi-bell"></i>
                <span>View My Sold Items</span>
            </a>
        </li>
        

        <!-- List Items  -->
        <!-- <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('sys/'); ?>">
                <i class="bi bi-bell"></i>
                <span>Practice Dashboard</span>
            </a>
        </li>-->

    </ul>
</aside>
