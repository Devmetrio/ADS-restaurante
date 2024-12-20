<?php
class viewMensajeValidacion
{
    public function viewMensajeValidacionShow($icono, $titulo, $texto, $id, $accion = null,)
    {
        if ($accion == null) {
?>
            <script>
                Swal.fire({
                    icon: "<?= $icono ?>",
                    title: "<?= $titulo ?>",
                    text: "<?= $texto ?>",
                    showCancelButton: true,
                    confirmButtonText: "SI",
                    denyButtonText: "NO",
                    heightAuto: false
                }).then((result) => {
                    let valor = "cancelar";
                    if (result.isConfirmed) {
                        valor = "aceptar"
                    }
                    window.location.href = "/src/ModuloServicio/UCgenerarPedidoPlato/getPedidos.php?opcion="+ valor + "&idMesa=<?= $id ?>";
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
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    denyButtonText: "Cancelar",
                    heightAuto: false
                }).then((result) => {
                    let valor = "cancelar";
                    if (result.isConfirmed) {
                        valor = "aceptar"
                    }
                    window.location.href = "/src/ModuloAdministracion/UCgestionarMesas/getMesas.php?opcion=" + valor + "&idMesa=<?= $id ?>&accion=<?= $accion ?>";
                });
            </script>
            <script>
                Swal.fire({
                    icon: "<?= $icono ?>",
                    title: "<?= $titulo ?>",
                    text: "<?= $texto ?>",
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    denyButtonText: "Cancelar",
                    heightAuto: false
                }).then((result) => {
                    let valor = "cancelar";
                    if (result.isConfirmed) {
                        valor = "aceptar";
                    }
                    window.location.href = "/src/ModuloAdministracion/UCgestionarUsuarios/getUsuarios.php?opcion=" + valor + "&idUsuario=<?= $id ?>&accion=<?= $accion ?>";
                });
            </script>
<?php
        }
    }
}
?>