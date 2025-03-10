<?php include_once 'Views/template-principal/header.php'; ?>


<!-- Start Content Page -->
<div class="container-fluid bg-light py-5">
    <div class="col-md-6 m-auto text-center">
        <h1 class="h1">Contactanos</h1>
        <p>
            Si tienes alguna pregunta, sugerencia o necesitas más información, no dudes en ponerte en contacto con nosotros. Nuestro equipo está disponible para asistirte de manera rápida y eficiente.
        </p>
    </div>
</div>



<!-- Start Contact -->
<div class="container py-5">
    <div class="row py-5">
        <form class="col-md-9 m-auto" method="post" role="form">
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <label for="inputname">Nombre</label>
                    <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Nombre">
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label for="inputemail">Correo Electrónico</label>
                    <input type="email" class="form-control mt-1" id="email" name="email" placeholder="Correo Electrónico">
                </div>
            </div>
            <div class="mb-3">
                <label for="inputsubject">Asunto</label>
                <input type="text" class="form-control mt-1" id="subject" name="subject" placeholder="Asunto">
            </div>
            <div class="mb-3">
                <label for="inputmessage">Mensaje</label>
                <textarea class="form-control mt-1" id="message" name="message" placeholder="Mensaje" rows="8"></textarea>
            </div>
            <div class="row">
                <div class="col text-end mt-2">
                    <button type="submit" class="btn btn-success btn-lg px-3">Hablemos</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Contact -->



<?php include_once 'Views/template-principal/footer.php'; ?>

</body>

</html>