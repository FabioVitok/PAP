<?php include __DIR__ . "/../includes/header.php"; ?>

<style> body { background-color: black; } </style>

<div class="container-fluid p-0 bg-black"
    style="min-height: 100vh; background-image: url('/assets/images/background_contact.jpg');
    background-size: cover; background-position: center;">
    <div class="container py-5">
        <h4 class="text-white mb-4" style="font-size: 24px;">
            Send Us A Message
            <span class="badge bg-light" style="color: black;">:</span>
        </h4>
        <div class="row">
            <div class="col-lg-8">
                <div class="card bg-black text-white" style="border: 2px solid white;">
                    <div class="card-body p-4">
                        <form id="contactForm" method="POST" action="/contact" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 24px;">Name</label>
                                <input type="text" name="name" class="form-control bg-black text-white border-light" id="name" required>
                                <div class="valid-feedback">Valid Name!</div>
                                <div class="invalid-feedback">Please provide your name.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 24px;">Email</label>
                                <input type="email" name="email" class="form-control bg-black text-white border-light" id="email" required>
                                <div class="valid-feedback">Valid Email!</div>
                                <div class="invalid-feedback">Please provide a valid email.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 24px;">Subject</label>
                                <input type="text" name="subject" class="form-control bg-black text-white border-light" id="subject" required>
                                <div class="valid-feedback">Valid Subject!</div>
                                <div class="invalid-feedback">Please provide a subject.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-size: 24px;">Message</label>
                                <textarea name="message" class="form-control bg-black text-white border-light" id="message" rows="5" required></textarea>
                                <div class="valid-feedback">Valid Message!</div>
                                <div class="invalid-feedback">Please write a message.</div>
                            </div>
                            <button type="submit" class="btn btn-outline-light">Send</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card bg-black text-white" style="border: 2px solid white;">
                    <div class="card-body p-4">
                        <h5 class="card-title">Info</h5>
                        <hr class="bg-light">
                        <p><strong>Email:</strong><br>SendUsAMessage@imoral.com</p>
                        <p><strong>Instagram:</strong><br>@imoral_clothes</p>
                        <p><strong>Hours:</strong><br>Mon-Sat: 9am-6pm</p>
                        <div class="text-center mt-3">
                            <img src="/assets/images/imoral_logo2_transp.png" alt="imoral Logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>