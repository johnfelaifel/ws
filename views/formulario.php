<!doctype html>
<html lang="en">

<head>
    <title>Pruebas</title>
</head>
<body>
    <form method="POST" id="formulario" enctype="multipart/form-data" action="http://localhost/Simec/ws/Usuario/getOnePost">

        <label for="id">Ingrese El Id del Registro</label>
        <input type="text" name="id" id="id" class="form-control">
        <br>

        <label for="nombre">Ingrese los nombres</label>
        <input type="text" name="nombres" id="nombres" class="form-control">
        <br>

        <label for="apellido">Ingrese los apellidos</label>
        <input type="text" name="apellidos" id="apellidos" class="form-control">
        <br>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="action" id="action" class="btn btn-success">Enviar</input>
        </div>

    </form>
</body>
</html>
