<main id="main" class="main">
    <head>
        <style>
            .my-script {
                font-size: 24px;
                color: #333;
                font-family: Arial, sans-serif;
            }
        </style>
    </head>

    <div class="pagetitle">
        <h1>Welcome</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('ewms/web'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Welcome</li>
            </ol>
    </div>
    <body>

        <p>
        <h1>My PHP page</h1>
        </p>


        <p class="my-script">
            <?php
            $nature = "small for me";
            echo "Hello World!!!<br>";
            echo "Hello World is " . $nature . "<br>";
            ?>
        </p>


        <p class="my-script">
            <?php
            $x = 5;
            $y = "John";
            echo $x . "<br>";
            echo $y;
            ?>
        </p>


        <?php
        echo "<pre>"; // Use <pre> tag for better formatting
        var_dump(5);
        var_dump("John");
        var_dump(3.14);
        var_dump(true);
        var_dump([2, 3, 56]);
        var_dump(NULL);
        echo "</pre>"; // Close <pre> tag
        ?>
        
        <br> <!-- Add a break here -->
        
        <?php
        $a = $b = $c = "Fruit";

        echo $a . "<br>";
        echo $b . "<br>";
        ?>






    </body>
</main>
