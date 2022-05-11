<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="/admin/validaLogin" method="post">
        <label>E-mail</label>
        <input type="text" name="email" required>
        <br />
        <label>Senha</label>
        <input type="text" name="senha" required>
        <br />
        <input type="submit" value="Efetuar login">
    </form>
</body>
</html>