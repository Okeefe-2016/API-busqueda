<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<img src="<?php echo $message->embed('img/okeefe.jpg'); ?>">
<br>
<h2>Datos de Contacto</h2>
<br>
<ul>
    <li><strong>Nombre: </strong><?php echo $data->nombre . ' ' . $data->apellido ?></li>
    <li><strong>Email: </strong><?php echo $data->email ?></li>
    <?php if($data->telefono){ ?>
    <li><strong>Teléfono: </strong><?php echo $data->telefono ?></li> <?php } ?>
    <?php if($data->fecha_nacimiento){ ?>
    <li><strong>Fecha de Nacimiento: </strong><?php echo $data->fecha_nacimiento ?></li><?php } ?>
    <?php if($data->comentarios){ ?>
    <li><strong>Posición: </strong><?php echo $data->comentarios ?></li><?php } ?>
</ul>
</body>
</html>

