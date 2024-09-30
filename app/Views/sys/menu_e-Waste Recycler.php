<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('sys/dashboard'); ?>" >
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- View Inventory Nav -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('sys/viewEwrInventory'); ?>" >
                <i class="bi bi-card-list"></i>
                <span>View Inventory</span>
            </a>
        </li>


        <!-- Report Generation -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('sys/view_reports'); ?>">
                <i class="bi bi-file-earmark-text"></i>
                <span>Report Generation</span>
            </a>
        </li>






    </ul>
</aside>
