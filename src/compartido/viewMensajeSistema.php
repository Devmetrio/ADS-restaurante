<?php
class viewMensajeSistema
{
  public function viewMensajeSistemaShow($icono, $titulo, $texto, $ruta = null)
  {
    if ($ruta == null) {
?>
      <script>
        Swal.fire({
          icon: "<?= $icono ?>",
          title: "<?= $titulo ?>",
          text: "<?= $texto ?>",
          confirmButtonText: "Ok",
          heightAuto: false
        });
      </script>
    <?php
    } else {
    ?>
      <script>
        Swal.fire({
          icon: "<?= $icono ?>",
          title: "<?= $titulo ?>",
          text: "<?= $texto ?>",
          confirmButtonText: "Ok",
          heightAuto: false
        }).then((result) => {
          if (result.isConfirmed) {
            localStorage.removeItem('comanda'); 
            localStorage.removeItem('comanda'); 
                        // Verifica si hay una acción específica y redirige según corresponda
                        if ('<?= $accion ?>' === 'btnHabilitar' || '<?= $accion ?>' === 'btnDeshabilitar') {
                            // Si la acción es relacionada con mesas
                            window.location.href = "<?= $ruta ?>?opcion=<?= isset($opcion) ? $opcion : '' ?>&idMesa=<?= $id ?>&accion=<?= $accion ?>";
                        } else if ('<?= $accion ?>' === 'btnHabilitarUsuario' || '<?= $accion ?>' === 'btnDeshabilitarUsuario') {
                            // Si la acción es relacionada con usuarios
                            window.location.href = "<?= $ruta ?>?opcion=<?= isset($opcion) ? $opcion : '' ?>&idUsuario=<?= $id ?>&accion=<?= $accion ?>";
                        } else {
                            // Redirige normalmente a la ruta proporcionada
                            window.location.href = "<?= $ruta ?>";
                        }
          }
        });
      </script>
<?php
    }
  }
}
?>