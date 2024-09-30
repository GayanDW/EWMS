<!DOCTYPE html>
<html>
<head>
    <title>PHP Logic Examples</title>
</head>
<body>

<main id="main" class="main">
    <div>
        <h1>PHP Logic Output</h1>
        
        <?php if (!empty($message1)): ?>
            <p><?= esc($message1); ?></p>
        <?php endif; ?>

        <?php if (!empty($message2)): ?>
            <p><?= esc($message2); ?></p>
        <?php endif; ?>

        <?php if (!empty($exerciseOutput)): ?>
            <p><?= esc($exerciseOutput); ?></p>
        <?php endif; ?>
    </div>
</main>

</body>
</html>

