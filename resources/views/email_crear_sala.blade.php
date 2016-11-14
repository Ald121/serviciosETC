<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>ETC | BIENVENIDO </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
  </head>
  <body>
  <!-- END HEADER -->
  <style type="text/css">
.imputsinicio{
box-shadow:-webkit-box-shadow: 0px 3px 5px 0px rgba(179,179,179,1);
-moz-box-shadow: 0px 3px 5px 0px rgba(179,179,179,1);
box-shadow: 0px 3px 5px 0px rgba(179,179,179,1);
}
.main-content{
    font-family: Arial, sans-serif;
      text-align: center;
    background: rgb(253, 253, 253);
    width: 60%;
    border: 1px #CECCCC solid;
        margin-left: 15%;
}
.find{
       padding-bottom: 20px;

}
.encabezado{
    background: #6BB557;
    margin-left: 20px;
    margin-right: 20px;
}
.cuerpo{
border: 1px #CECCCC solid;
    margin-top: 20px;
    margin-left: 20px;
    margin-right: 20px;
    background: rgba(129, 218, 245, 0.18);
}
.saludo{

}
.tabbertab{
        margin: 25px;
}

.footer{
       background: #6BB557;
    margin-left: 20px;
    margin-right: 20px;
    padding: 20px;
    color: white;
}
  </style>
  <!-- BEGIN CONTENT -->
<div class="main-content">
<div class="encabezado">
    <!-- Logo -->
    <div id="resul_cuenta"></div>
          <div style=" padding-top:15px; "><img alt="" src="http://etc.innovaservineg.com/img/logo_niaby2.png"></div>
    <!-- End Logo -->
      </div>
  <!-- Find Tabber Find-->
  <div class="find">
    <div class="container cuerpo">
        <div class="tabbertab " title="">
          <form href="" >
            <div class="row ">
              <div class="span12">
                <div class="saludo">
                <p>  {{$saludo}}</p><br><br>
                </div>
                </div>
                <div class="span4">
                 <p>  {{$cuerpo}}</p><br><br>
              </div>
              <hr><br>
                <div class="span4">
                <label> 
                <STRONG>CLAVE: {{$pass_sala}}</STRONG><br><br>
                  <a href="http://etc.innovaservineg.com" id="btn_activar" type="button">http://etc.innovaservineg.com</a>
                </label>  
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="footer">ETC 2016</div>
    </div>
<br>
<br>
<br>
  <!-- END CONTENT -->
  </body>
</html>