<?php
class formComprobantePago
{
    public function formComprobantePagoShow($idMesa)
    {?>
      <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Formulario Comprobante de Pago</title>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
            <style>
 
            </style>
        </head>
        <body>
        
        <?php
        echo $idMesa;
        ?>
        </body>
        <script>
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

        </html>
      


    <?php
    }
    
}
?>