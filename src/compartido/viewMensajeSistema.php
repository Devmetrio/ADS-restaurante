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
            window.location.href = "<?= $ruta ?>";
          }
        });
      </script>
<?php
    }
  }
}
?>