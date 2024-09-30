<!DOCTYPE html>
<html>
<head>
    <title>Demo Static Variable</title>
</head>
<body>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Static Variable Demonstration</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('ewms/web'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Demo Stat</li>
            </ol>
        </nav>
    </div>

    <!-- Output from the controller -->
    <div>
        <p>Static variable increment:  <br> <?= $output; ?></p>
    </div>
</main>

</body>
</html>
