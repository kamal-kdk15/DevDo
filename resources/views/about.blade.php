@extends('layouts.app')

@section('content')
<header class="header-section" style="background-image: url('https://i.pinimg.com/originals/9a/e1/3e/9ae13e5ddacb054aa2eb3098af53850f.gif'); background-size: cover; background-position: center;">
    <div class="container text-center">
        <h1>About Us</h1>
        <p>Learn more about our mission, vision, and what makes us unique.</p>
    </div>
</header>

<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2>Our Mission</h2>
                    <p>We aim to connect developers, designers, and companies to foster collaboration and innovation. Our platform allows users to create profiles, showcase their projects, and work together on exciting new ideas.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image">
                    <img src="https://i.pinimg.com/736x/45/cf/dd/45cfddcfe918827ce09112aa7e219ac4.jpg" alt="Our Mission Image">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="about-image">
                    <img src="https://i.pinimg.com/564x/4a/5c/a0/4a5ca0989ddca758537165efd9266396.jpg" alt="Our Vision Image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h2>Our Vision</h2>
                    <p>Our vision is to become the leading platform for creative professionals to collaborate and achieve their dreams. We believe in the power of teamwork and strive to provide the best tools and environment for our users to succeed.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features-section" id="features">
    <div class="container">
        <h2 class="text-center mb-5">Our Features</h2>
        <div class="row">
            <div class="col-lg-4">
                <div class="feature-box animated">
                    <div class="feature-image">
                        <img src="https://i.pinimg.com/564x/82/53/f4/8253f46af6e9eaa5699b8bf1387653e9.jpg" alt="Developer Accounts">
                    </div>
                    <div class="feature-content">
                        <h3>Developer Accounts</h3>
                        <p>Developers can showcase their projects, skills, and connect with other users.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-box animated">
                    <div class="feature-image">
                        <img src="https://i.pinimg.com/564x/e6/03/03/e603030f4b3c67c230be9c878bb25fd8.jpg" alt="Designer Accounts">
                    </div>
                    <div class="feature-content">
                        <h3>Designer Accounts</h3>
                        <p>Designers can post their portfolios, collaborate on group projects, and more.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-box animated">
                    <div class="feature-image">
                        <img src="https://i.pinimg.com/736x/28/f6/2e/28f62e1d6a2bde1e6ac0ae86b7d008df.jpg" alt="Company Accounts">
                    </div>
                    <div class="feature-content">
                        <h3>Company Accounts</h3>
                        <p>Companies can post job vacancies, manage applications, and engage with potential hires.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="call-to-action-section"  style="background-image: url('https://i.pinimg.com/originals/23/91/a5/2391a5410336dda4f23978a93ebb6783.gif'); background-size: cover; background-position: center;">
    <div class="container" >
        <h2>Ready to Get Started?</h2>
        <p>Join our community of developers, designers, and companies. Explore more posts now!</p>
        <a href="{{ route('explore.posts') }}" class="btn btn-primary" style="background-color: #8E1A5F; border-color: #8E1A5F;">Explore More</a>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Add slideInUp class to feature boxes for animation
        $('.feature-box').addClass('slideInUp');
    });
</script>
@endsection

<style>
    /* Global styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
    }

    .header-section {
        background-image: url('https://i.pinimg.com/originals/81/54/f1/8154f194b885dab7d8dfda870ebdf40c.gif');
        background-size: cover;
        background-position: center;
        color: #fff;
        padding: 100px 0;
        text-align: center;
        position: relative;
        z-index: 1;
        margin-top: -2%;
        height: 65vh;
    }

    .header-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); 
        z-index: -1;
    }

    .about-section {
        padding: 100px 50px;
        background-color: #0d0d27;
        color: #fff;
    }

    .about-content h2 {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .about-content p {
        font-size: 18px;
        line-height: 1.6;
    }

    .about-image img {
        max-width: 100%;
        height: 80%;
        display: block;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .features-section {
        padding: 80px 0;
        background-color: #1a1a41;
        color: #fff;
    }
    .feature-box {
        background-color: rgba(255, 255, 255, 0.1);
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .feature-box:hover {
        transform: translateY(-5px); 
    }


    .feature-image img {
        width: 100%;
        border-radius: 10px;
        height: 250px;
    }

    .feature-content {
        padding: 20px;
    }

    .feature-box h3 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #AA336A;
    }

    .feature-box p {
        font-size: 18px;
        line-height: 1.6;
    }

    .call-to-action-section {
        background-color: #0d0d27;
        color: #fff;
        text-align: center;
        padding: 100px 0;
    }

    .call-to-action-section h2 {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .call-to-action-section p {
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .btn-primary {
        background-color: #AA336A;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 18px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn-primary:hover {
        background-color: #8E1A5F;
        transform: scale(1.05); /* Optional: Scale up on hover */
    }

    /* Keyframe animation */
    @keyframes slideInUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Additional styling for animated class */
    .slideInUp {
        animation: slideInUp 0.8s ease-out forwards;
    }
</style>

