<!DOCTYPE html>
<html>
    <head>
        <title>Input Form</title>
    </head>
    <body>

        <main id="main" class="main">
            <div>
                <h1>Enter Values</h1>
                <?= form_open('prac/practice4'); ?>
                <div>
                    <label for="a">Value A:</label>
                    <input type="number" name="a" id="a">
                </div>

                <div>
                    <label for="b">Value B:</label>
                    <input type="number" name="b" id="b">
                </div>

                <div>
                    <label for="t">Value T:</label>
                    <input type="number" name="t" id="t">
                </div>
                <button type="submit">Submit</button>
                <?= form_close(); ?>

            </div>
        </main>

    </body>
</html>

