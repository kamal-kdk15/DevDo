@extends('layouts.app')

@section('content')
<section class="privacy-policy-hero">
    <div class="container" style="text-align: center">
        <h1 class="privacy-title">Privacy Policy</h1>
        <p class="privacy-subtitle">Your privacy is critically important to us. Here's how we protect it.</p>
    </div>
</section>

<section class="privacy-policy-content" style="margin: auto; padding: 30px">
    <div class="container">
        <div class="privacy-card">
            <div class="privacy-content">
                <h2><i style="font-size: 20px" class="fas fa-info-circle"></i> Introduction</h2>
                <p>Welcome to our website. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website. Please read this policy carefully to understand our practices regarding your information.</p>

                <h2><i style="font-size: 20px" class="fas fa-database"></i> Information We Collect</h2>
                <p>We may collect information about you in a variety of ways. The information we may collect on the website includes:</p>
                <ul>
                    <li><strong>Personal Data:</strong> Personally identifiable information, such as your name, shipping address, email address, and telephone number.</li>
                    <li><strong>Derivative Data:</strong> Information our servers automatically collect when you access the website, such as your IP address, browser type, and operating system.</li>
                    <li><strong>Usage Data:</strong> Usage data includes information about how you use our website, such as the pages you visit, the links you click, and the searches you make.</li>
                </ul>

                <h2><i style="font-size: 20px" class="fas fa-user-check"></i> Use of Your Information</h2>
                <p>Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience. Specifically, we may use the information collected about you to:</p>
                <ul>
                    <li>Create and manage your account.</li>
                    
                    <li>Provide you with customer support.</li>
                    <li>Request feedback and contact you about your use of the website.</li>
                </ul>

                <h2><i style="font-size: 20px" class="fas fa-share-alt"></i> Disclosure of Your Information</h2>
                <p>We may share information we have collected about you in certain situations. Your information may be disclosed as follows:</p>
                <ul>
                    <li><strong>By Law or to Protect Rights:</strong> If we believe the release of information about you is necessary to respond to legal process, to investigate or remedy potential violations of our policies, or to protect the rights, property, and safety of others.</li>
                    <li><strong>Business Transfers:</strong> We may share or transfer your information in connection with, or during negotiations of, any merger, sale of company assets, financing, or acquisition of all or a portion of our business to another company.</li>
                    <li><strong>Third-Party Service Providers:</strong> We may share your information with third parties that perform services for us or on our behalf, such as payment processing, data analysis, email delivery, hosting services, customer service, and marketing assistance.</li>
                </ul>

                <h2><i style="font-size: 20px" class="fas fa-envelope"></i> Contact Us</h2>
                <p>If you have questions or comments about this Privacy Policy, please contact us at:</p>
                <address>
                    <strong>Company Name</strong><br>
                    1234 Street Name, City, State, 12345<br>
                    Email: info@company.com<br>
                    Phone: (123) 456-7890
                </address>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    body {
        background-color: #0d0d27;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .privacy-policy-hero {
        background: linear-gradient(to right, #AA336A, #45a29e);
        padding: 20px 0;
        text-align: center;
        color: #fff;
    }

    .privacy-title {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .privacy-subtitle {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .privacy-policy-content {
        padding: 20px 0;
    }

    .privacy-card {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        max-width: 800px;
        margin: 0 auto;
    }

    .privacy-content h2 {
        color: #FFD700;
        margin-top: 20px;
        border-bottom: 2px solid #AA336A;
        padding-bottom: 10px;
        display: flex;
        align-items: center;
        font-size: 22px;
    }

    .privacy-content h2 i {
        margin-right: 10px;
    }

    .privacy-content p, .privacy-content ul {
        color: #fff;
        margin-bottom: 15px;
        font-size: 16px;
        line-height: 1.6;
    }

    .privacy-content ul {
        list-style-type: disc;
        padding-left: 20px;
    }

    .privacy-content li {
        margin-bottom: 10px;
    }

    address {
        color: #45a29e;
        font-style: normal;
    }
</style>
@endsection
