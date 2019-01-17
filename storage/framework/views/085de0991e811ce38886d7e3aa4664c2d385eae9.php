<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<style media="screen">
.container {width: 80%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;}
.center{text-align: center;}
</style>
<body>
  <div class="container">
    <h1 class="center">Request for Work with us</h1>
    <strong>Nombre: </strong> <?php echo e($datos['nombre']); ?> <br>
    <strong>Phone: </strong> <?php echo e($datos['telefono']); ?><br>
    <strong>Email client: </strong> <?php echo e($datos['email']); ?><br>
    <strong>Option: </strong><?php echo e($datos['Options']); ?><br>
    <strong>Comment: </strong>
    <p><?php echo e($datos['comentario']); ?></p>    
  </div>
</body>
</html>
