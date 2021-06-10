<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
<title>Bootstrap Simple Login Form with Blue Background</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> 
<style>
body {
	color: #fff;
	background: #3598dc;
	font-family: 'Roboto', sans-serif;
}
.form-control {
	height: 41px;
	background: #f2f2f2;
	box-shadow: none !important;
	border: none;
}
.form-control:focus {
	background: #e2e2e2;
}
.form-control, .btn {        
	border-radius: 3px;
}
.signup-form {
	width: 400px;
	margin: 30px auto;
}
.signup-form form {
	color: #999;
	border-radius: 3px;
	margin-bottom: 15px;
	background: #fff;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	padding: 30px;
}
.signup-form h2  {
	color: #333;
	font-weight: bold;
	margin-top: 0;
}
.signup-form hr  {
	margin: 0 -30px 20px;
}    
.signup-form .form-group {
	margin-bottom: 20px;
}
.signup-form input[type="checkbox"] {
	margin-top: 3px;
}
.signup-form .row div:first-child {
	padding-right: 10px;
}
.signup-form .row div:last-child {
	padding-left: 10px;
}
.signup-form .btn {        
	font-size: 16px;
	font-weight: bold;
	background: #3598dc;
	border: none;
	min-width: 140px;
}
.signup-form .btn:hover, .signup-form .btn:focus {
	background: #2389cd !important;
	outline: none;
}
.signup-form a {
	color: #fff;
	text-decoration: underline;
}
.signup-form a:hover {
	text-decoration: none;
}
.signup-form form a {
	color: white;
	text-decoration: none;
}	
.signup-form form a:hover {
	text-decoration: underline;
}
.signup-form .hint-text  {
	padding-bottom: 15px;
	text-align: center;
}
</style>
</head>
<body>
<div class="signup-form">
    <form action="{{route('registersave')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
		<h2>Registrate</h2>
		<p>Crea tu cuenta</p>
		<hr>
        <div class="form-group">
        	<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$" required="required">
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion" pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$" required="required">
        </div>
        <div class="form-group">
        	<select class="form-control" name="tipo_documento" id="tipo_documento">
                                                
                                                <option value="0" disabled>Seleccione</option>
                                                <option value="NIT">NIT</option>
                                                <option value="CEDULA">CEDULA</option>
                                                
                            
                                            </select>
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" id="num_documento" name="num_documento" class="form-control" placeholder="Ingrese el número documento" pattern="[0-9]{0,15}" required="required">
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" id="telefono" name="telefono" class="form-control" placeholder="Ingrese el telefono" pattern="[0-9]{0,15}" required="required">
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" id="email" name="email" placeholder="Ingrese el correo" required="required">
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" id="usuario" name="usuario" class="form-control" placeholder="Ingrese el usuario" pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
		<div class="form-group">
        <input type="file" id="imagen" name="imagen" class="form-control">
        </div>        
        
		<div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
			<a  href="{{route('/')}}" class="btn btn-primary btn-lg">	Cancelar</div></a>
        </div>
		
            
        
    </form>
</div>
</body>
</html>