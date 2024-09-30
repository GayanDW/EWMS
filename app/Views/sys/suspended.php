<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Warning Message</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS for extra styling (optional) -->
        <style>
            .warning-page {
                min-height: 100vh;
            }
            .warning-sign {
                color: #ffc107; /* Bootstrap warning color */
            }
        </style>
    </head>

    <body>
        <div class="d-flex justify-content-center align-items-center warning-page">
            <div class="text-center">
                <div class="mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" fill="currentColor" class="bi bi-exclamation-triangle-fill warning-sign" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-2.018 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </div>
                <div>
                    <h1>Alert!</h1>
                    <!-- Dynamically display the message from the controller -->
                    <p>You are suspended</p>
                    
                    <a href="javascript:history.back()" class="btn btn-secondary">Go Back</a>
                    <!-- Update the link to direct users to the desired page -->
                    <a href="/ems/web/" class="btn btn-primary">Go to home page</a>
                </div>
            </div>
        </div>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>