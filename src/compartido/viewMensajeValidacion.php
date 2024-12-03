<?php
class viewMensajeValidacion
{
    public function viewMensajeValidacionShow($icono, $titulo, $texto, $id, $accion)
    {
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
                window.location.href = "/src/ModuloAdministracion/UCgestionarMesas/getMesas.php?opcion="+valor+"&idMesa=<?=$id?>&accion=<?=$accion?>";
            });
        </script>
<?php
    }
}
?>