@extends('layouts.app') {{-- Assuming your layout structure --}}

@section('content')
    <section class="contact-section">
        <div class="container">
            <div class="contact-content" >
                <h2 style="color: #ff00ff">Contact Us</h2>
                <p>Get in touch with us for any inquiries or feedback. We'd love to hear from you!</p>
                <div class="contact-form">
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" placeholder="Enter your message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
<style>

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #1f1f1f; 
    color: #fff;
    margin: 0;
    padding: 0;
    background: url('https://i.pinimg.com/originals/d6/c2/bc/d6c2bc5eef34797e9831992d76de249c.gif') ;
    background-size: cover; background-position: center;
    background-size: cover; 
    background-position: center; 
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    
}

.contact-section {
  
    color: #fff;
    padding: 100px 0; 
    text-align: center;
}

.contact-content {
    max-width: 600px;
    margin: 0 auto;
    margin-top: -3%;
    padding: 0 20px;
   background-color: #121027;
    background-size: cover; background-position: center;
    background-size: cover; 
    background-position: center; 
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    text-align: center;
    padding: 40px;

}

.contact-content h2 {
    font-size: 3rem;
    margin-bottom: 20px;
}

.contact-content p {
    font-size: 1.2rem;
    margin-bottom: 30px;
}

.contact-form {
    background-color: rgba(255, 255, 255, 0.05);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    margin-top: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group textarea {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: none;
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
    border-radius: 5px;
    outline: none;
    transition: background-color 0.3s, border-color 0.3s;
}

.form-group textarea {
    resize: vertical;
}

.form-group input[type="text"]:focus,
.form-group input[type="email"]:focus,
.form-group textarea:focus {
    background-color: rgba(255, 255, 255, 0.2);
}

.submit-btn {
    background-color: #ff00ff; 
    color: #fff;
    border: none;
    padding: 12px 24px;
    font-size: 1.1rem;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.submit-btn:hover {
    background-color: #e600e6; /* Darker pink on hover */
}

</style>