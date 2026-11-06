<section class="py-5" style="background:#faf7f2; min-height: 80vh;">
    <div class="container py-3">
        <div class="text-center mb-5">
            <span class="section-eyebrow">GET IN TOUCH</span>
            <h1 class="section-title">Contact Laguna University Stall</h1>
            <p class="section-subtitle mx-auto" style="max-width: 550px;">
                Have questions regarding orders, catering for campus events, or student partnerships? We'd love to hear from you.
            </p>
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <form id="contactForm" onsubmit="event.preventDefault(); alert('Thank you! Your message has been sent to Laguna University Stall administrators.'); this.reset();">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Your Full Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Juan Dela Cruz" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="student@laguna.edu.ph" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Subject</label>
                            <input type="text" class="form-control" name="subject" placeholder="Inquiry / Feedback / Event Order" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Your Message</label>
                            <textarea class="form-control" name="message" rows="4" placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn hero-order-btn w-100 py-3 justify-content-center">
                            <span>Send Message</span>
                            <i class="bi bi-send ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="d-flex flex-column gap-3">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <div class="d-flex align-items-center gap-3">
                            <div class="site-feat-icon" style="background:#fef3c7; color:#d97706;">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Campus Location</h6>
                                <p class="small text-muted mb-0">Laguna University Campus Grounds<br>Santa Cruz, Laguna</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <div class="d-flex align-items-center gap-3">
                            <div class="site-feat-icon" style="background:#ecfdf5; color:#059669;">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Email Inquiries</h6>
                                <p class="small text-muted mb-0">bsentrep@laguna.edu.ph<br>orders@qstall.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <div class="d-flex align-items-center gap-3">
                            <div class="site-feat-icon" style="background:#eff6ff; color:#2563eb;">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Operating Hours</h6>
                                <p class="small text-muted mb-0">Monday – Friday: 7:30 AM – 5:30 PM<br>Saturday: 8:00 AM – 1:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
