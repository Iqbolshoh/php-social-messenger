<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="0;url=../login/">
    <script>
        fetch('../api/auth/logout.php', {method: 'POST'})
            .then(() => window.location.href = '../login/');
    </script>
    <style>
        body{min-height:100vh;margin:0;font-family:'Segoe UI','Roboto','Arial',sans-serif;background:#7F7FD5;background:-webkit-linear-gradient(to right,#91EAE4,#86A8E7,#7F7FD5);background:linear-gradient(to right,#91EAE4,#86A8E7,#7F7FD5);display:flex;align-items:center;justify-content:center;}
        .logout-box{background:rgba(255,255,255,0.93);box-shadow:0 8px 32px 0 rgba(127,127,213,0.13);border-radius:18px;padding:32px 36px;display:flex;flex-direction:column;align-items:center;min-width:230px;animation:fadeInUp 1s cubic-bezier(.77,0,.18,1.01);}
        .logout-box p{font-size:1.16rem;font-weight:600;color:#7F7FD5;letter-spacing:0.2px;margin:0;text-align:center;}
        .loader{margin:28px auto 0;width:48px;height:48px;display:block;position:relative;}
        .loader:before,.loader:after{content:"";box-sizing:border-box;position:absolute;inset:0;border-radius:50%;border:4px solid #7F7FD5;animation:loadSpin 1.2s linear infinite;}
        .loader:after{border-color:#91EAE4 transparent #91EAE4 transparent;animation-delay:.6s;}
        @keyframes fadeInUp{from{transform:translateY(30px) scale(0.98);opacity:0;}to{transform:none;opacity:1;}}
        @keyframes loadSpin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
    </style>
</head>
<body>
    <div class="logout-box">
        <span class="loader"></span>
        <p>Logging out...</p>
    </div>
</body>
</html>