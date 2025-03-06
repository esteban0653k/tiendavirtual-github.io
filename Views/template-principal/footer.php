 <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header bg-success">
                 <h5 class="modal-title"><i class="fas fa-cart-arrow-down"></i>Carrito</h5>
                 <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body bg-light">
                 <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover align-middle" id="tableListaCarrito">
                         <thead class="mondongo">
                             <tr>
                                 <th>#</th>
                                 <th>Producto</th>
                                 <th>Precio</th>
                                 <th>Cantidad</th>
                                 <th>SubTotal</th>
                                 <th></th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="d-flex justify-content-around mb-3">
                 <h3 id="totalGeneral"></h3>
                 <?php if (!empty($_SESSION['email'])) { ?>
                 <a class="btn btn-outline-primary" href="<?php echo BASE_URL . 'clientes'; ?>">Procesar Pedido</a>
                 <?php }else{ ?>
                    <a class="btn btn-outline-primary" href="#" onclick="abrirModalLogin();">Iniciar Sesion</a>
                <?php } ?>
             </div>
         </div>
     </div>
 </div>

 <!-- login -->


 <div id="modalLogin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header bg-success">
                 <h5 class="modal-title" id="titleLogin">Iniciar Sesion</h5>
                 <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body bg-light m-1">
                 <form method="get" action="">
                     <div class="text-center">
                         <img class="img-thumbnail" src="<?php echo BASE_URL . 'assets/img/logo.png'; ?>" alt="" width="160">
                     </div>
                     <div class="row">
                         <div class="col-md-12" id="frmLogin">
                             <div class="form-group mb-3">
                                 <label for="correoLogin" class="mondongo"><i class="fas fa-envelope"></i>Correo</label>
                                 <input id="correoLogin" class="form-control" type="text" name="correoLogin" placeholder="Correo Electrónico">
                             </div>
                             <div class="form-group mb-3">
                                <label for="claveLogin" class="mondongo"><i class="fas fa-key"></i>Contraseña</label>
                                <input id="claveLogin" class="form-control" type="password" name="claveLogin" placeholder="Contraseña"> <!-- Cambiado a tipo password -->
                            </div>
                             <a href="#" id="btnRegister" class="mondongo">Todavia no tienes cuenta?</a>
                             <div class="float-end">
                                 <button class="btn btn-success" type="button" id="login">Login</button> 
                             </div>
                         </div>
                         <!-- formulario registro -->
                         <div class="col-md-12 d-none" id="frmRegister">
                             <div class="form-group mb-3">
                                 <label for="nombre" class="mondongo"><i class="fas fa-list"></i>Nombre de usuario</label>
                                 <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                             </div>
                             <div class="form-group mb-3">
                                 <label for="apellidos" class="mondongo"><i class="fas fa-list"></i>Apellido</label>
                                 <input id="apellidos" class="form-control" type="text" name="apellidos" placeholder="Apellido">
                             </div>
                             <div class="form-group mb-3">
                                 <label for="email" class="mondongo"><i class="fas fa-envelope"></i>Email</label>
                                 <input id="email" class="form-control" type="text" name="email" placeholder="email">
                             </div>
                             <div class="form-group mb-3">
                                 <label for="RegisterClave" class="mondongo"><i class="fas fa-key"></i>Contraseña</label>
                                 <input id="RegisterClave" class="form-control" type="password" name="RegisterClave" placeholder="Clave">
                             </div>
                             <a href="#" id="btnLogin" class="mondongo">Ya tienes cuenta?</a>
                             <div class="float-end">
                                 <button class="btn btn-danger" type="button" id="Registrarse">Registrarse</button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div>

         </div>
     </div>
 </div>



 <!-- Start Footer -->
 <footer class="bg-dark" id="tempaltemo_footer">
 <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-4 pt-5">
                <h2 class="h2 text-success border-bottom pb-3 border-light logo">National liquor</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li class="mondongo">
                        <i class="fas fa-map-marker-alt fa-fw"></i>
                        123 Consectetur at ligula 10660
                    </li>
                    <li>
                        <i class="fa fa-phone fa-fw"></i>
                        <a class="text-decoration-none mondongo" href="tel:010-020-0340">010-020-0340</a>
                    </li>
                    <li>
                        <i class="fa fa-envelope fa-fw"></i>
                        <a class="text-decoration-none mondongo" href="mailto:info@company.com">info@company.com</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row text-light mb-4 justify-content-center">
            <div class="col-12 mb-3">
                <div class="w-100 my-3 border-top border-light"></div>
            </div>
            <div class="col-12 text-center">
                <ul class="list-inline footer-icons">
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="http://facebook.com/">
                            <i class="fab fa-facebook-f fa-lg fa-fw fa-2x"></i> <!-- Tamaño aumentado -->
                        </a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/">
                            <i class="fab fa-instagram fa-lg fa-fw fa-2x"></i> <!-- Tamaño aumentado -->
                        </a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/">
                            <i class="fab fa-twitter fa-lg fa-fw fa-2x"></i> <!-- Tamaño aumentado -->
                        </a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.linkedin.com/">
                            <i class="fab fa-linkedin fa-lg fa-fw fa-2x"></i> <!-- Tamaño aumentado -->
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-auto">
                <label class="sr-only" for="subscribeEmail">Email address</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control bg-dark border-light" id="subscribeEmail" placeholder="Email address">
                    <div class="input-group-text btn-success text-light">Subscribe</div>
                </div>
            </div>
        </div>
    </div>

     <div class="w-100 bg-black py-3">
         <div class="container">
             <div class="row pt-2">
                 <div class="col-12">
                     <p class="text-left text-light">
                         Copyright &copy; 2024 National liquor
                         | Designed by <a rel="sponsored" href="#" target="_blank">Asmig</a>
                     </p>
                 </div>
             </div>
         </div>
     </div>

 </footer>
 <!-- End Footer -->

 <!-- Start Script -->
 <script src="<?php echo BASE_URL; ?>assets/js/jquery-1.11.0.min.js"></script>
 <script src="<?php echo BASE_URL; ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
 <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
 <script src="<?php echo BASE_URL; ?>assets/js/templatemo.js"></script>
 <script src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>
 <script src="<?php echo BASE_URL; ?>assets/js/carrito.js"></script>
 <script src="<?php echo BASE_URL; ?>assets/js/login.js"></script>
 <script src="<?php echo BASE_URL; ?>assets/js/es-MX.js"></script>
 <script>
     const base_url = '<?php echo BASE_URL; ?>';
 </script>
 <script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

 <!-- End Script -->