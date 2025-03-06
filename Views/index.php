<?php include_once 'Views/template-principal/header.php'; ?>

    <!-- Start Banner Hero -->
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="<?php echo BASE_URL; ?>./assets/img/bluelabel.png" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left align-self-center">
                                <h1 class="h1 text-success"><b>Blue label</b></h1>
                                <h3 class="mondongo">Descubre la Exclusividad: Blue Label, un Sabor que Marca la Diferencia</h3>
                                <p class="mondongo">
                                Descubre Blue Label, un whisky de lujo que combina suavidad y profundidad en cada sorbo. Con notas de frutas maduras y un toque de especias, es la elección perfecta para celebraciones o momentos de distinción. ¡Celebra la excelencia con Blue Label!
                                    <a rel="sponsored" class="text-success" href="http://localhost/tienda-virtual/principal/detail/32" target="_blank">Compra ya</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="<?php echo BASE_URL; ?>./assets/img/a.amarillo.png" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left align-self-center">
                                <h1 class="h1 text-success"><b>Aguardiente Amarillo</b></h1>
                                <h3 class="mondongo">Su color era amarillo vibrante como el sol y su sabor fresco y aromático.</h3>
                                <p class="mondongo">
                                Olor que recuerda la naturaleza con una entrada dulce y muy fresca. En boca, la sensación alcohólica, el anisado es término medio con unos destellos intensos de hinojo dulce.
                                <a rel="sponsored" class="text-success" href="http://localhost/tienda-virtual/principal/detail/30" target="_blank">Compra ya</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="<?php echo BASE_URL; ?>./assets/img/vodka.png" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1 text-success"><b>Smirnoff </b></h1>
                                <h3 class="mondongo">es el vodka número 1 del mundo, suave, versátil y galardonado con el oro.</h3>
                                <p class="mondongo">
                                Con su inigualable ingenio nacido de humildes comienzos, este icónico y pionero destilado se disfruta ahora en más de 130 países en todo el mundo, ya sea solo, en un refrescante Smirnoff Ice perfectamente frío o como el protagonista del cóctel favorito de tus comensales.
                                <a rel="sponsored" class="text-success" href="http://localhost/tienda-virtual/principal/detail/31" target="_blank">Compra ya</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <!-- End Banner Hero -->


    <!-- Start Categories of The Month -->
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1 text-success"><b>Categorias</b></h1>
                <p>
                Descubre nuestra selección de licores premium. Desde vinos y cervezas artesanales hasta destilados exquisitos, encuentra la bebida perfecta para cada ocasión.
                </p>
            </div>
        </div>
        <div class="row">
            <?php foreach ($data['categorias'] as $categoria) { ?>
             <div class="col-12 col-md-3 p-5 mt-3">
                <a href="<?php echo BASE_URL . 'principal/categorias/' . $categoria['id_categoria']; ?>"><img src="<?php echo $categoria['imagen']; ?>" class="rounded-circle img-fluid border"></a>
                <h5 class="text-center mt-3 mb-3">
                        <a href="<?php echo BASE_URL . 'principal/categorias/' . $categoria['id_categoria']; ?>"  style="text-decoration: none;">
                        <button type="button" class="btn btn-outline-warning">
                        <?php echo $categoria['nombreCategoria']; ?>
                        </button>
                        </a>
                    </button>
                </h5>
             </div>
            <?php } ?>
        </div>
    </section>
    <!-- End Categories of The Month -->


    <!-- Start Featured Product -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                <h1 class="h1 text-success"><b>LLega lo nuevo no te lo pierdas!!</b></h1>
                    <p class="mondongo">
                    ¡Descubre nuestros nuevos licores! Desde exquisitos whiskies hasta vibrantes cócteles, cada sorbo es una nueva aventura. No te pierdas la oportunidad de probar lo último en nuestra selección. ¡Brinda con lo mejor!.
                    </p>
                </div>
            </div>
            <div class="row">
                <?php foreach ($data['nuevoProductos'] as $producto) { ?>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="<?php echo BASE_URL . 'principal/detail/' . $producto['id_producto']; ?>">
                            <img src="/tienda-virtual/ventas/archivos/procesos/<?php echo $producto['ruta'];?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>" height="380px" >
                        </a>
                        <div class="card-body">
                            <ul class="list-unstyled d-flex justify-content-between">
                                <li>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                </li>
                                <li class="text-muted text-right"><?php echo MONEDA . ' ' . $producto['precio']; ?></li>
                            </ul>
                            <a href="<?php echo BASE_URL .'principal/detail/' . $producto['id_producto']; ?>" class="h2 text-decoration-none text-dark"><?php echo $producto['nombre']; ?></a>
                            <p class="card-text">
                            <?php echo $producto['descripcion']; ?>
                            </p>
                            <p class="text-muted">Reviews (24)</p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- End Featured Product -->

    <?php include_once 'Views/template-principal/footer.php'; ?>


</body>

</html>