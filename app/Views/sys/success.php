</html>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Success</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>


    <body>
        <div class="vh-100 d-flex justify-content-center align-items-center">
            <div>
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                         fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h1>Success!</h1>
                    <p><?= $message; ?></p>
                    <?php if ($message == 'Your account has been successfully verified.'): ?>
                        <a href="<?= base_url('sys/dashboard'); ?>" class="btn btn-primary">Go to Dashboard</a>
                    <?php elseif ($message == 'Another action was successful.'): ?>
                        <a href="<?= base_url('sys/another-page'); ?>" class="btn btn-primary">Go Back</a>
                    <?php else: ?>
                        <a href="<?= base_url('sys/default-page'); ?>" class="btn btn-primary">Default Action</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </body>





