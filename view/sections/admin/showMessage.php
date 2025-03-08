<!-- =====================Message Success====================== -->
<?php 
    if(
    isset($_GET['success'])
    && $_GET['success'] == 1
    && isset($_GET["message"])
    && isset($_GET["title"])
    )
    :?>
    <script>
        Swal.fire({
        timer: 2000,
        title: "<?=$_GET["message"]?>",
        text: "<?=$_GET["title"]?>",
        icon: "success"
        });
    </script>
<?php 
    endif;
?>
<!-- =====================Message error====================== -->
<?php 
    if(
    isset($_GET['error'])
    && $_GET['error'] == 1
    && isset($_GET["message"])
    && isset($_GET["title"])
    )
    :?>
    <script>
        Swal.fire({
        timer: 2000,
        timerProgressBar: true,
        title: "<?=$_GET["message"]?>",
        text: "<?=$_GET["title"]?>",
        icon: "error"
        });
    </script>
<?php 
    endif;
?>