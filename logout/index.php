<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="refresh" content="0;url=../login/">
    <script>
        fetch('../api/auth/logout.php', {
                method: 'POST'
            })
            .then(() => window.location.href = '../login/');
    </script>
</head>

<body>
    <p>Logging out...</p>
</body>

</html>