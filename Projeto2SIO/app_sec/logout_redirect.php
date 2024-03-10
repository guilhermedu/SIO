<!DOCTYPE html>
<html>
<head>
    <title>Logging Out...</title>
    <script>
        localStorage.clear();
        sessionStorage.clear();
        window.location.href = 'login.php';
        console.log("Logged out");
    </script>
</head>
<body>
    Logging out, please wait...
</body>
</html>
