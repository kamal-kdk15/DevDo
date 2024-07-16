@extends('layouts.app')

@section('content')
<section class="terms-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="terms-box">
                    <div class="terms-header text-center">
                        <h2>Terms & Conditions</h2>
                        <p>Welcome to DevDo. These terms and conditions outline the rules and regulations for the use of our platform.</p>
                    </div>
                    <div class="terms-content">
                        <div class="section">
                            <div class="icon"><i class="fas fa-info-circle"></i></div>
                            <div class="content">
                                <h3>Introduction</h3>
                                <p>Welcome to DevDo, a futuristic platform where users can create profiles, post projects, and collaborate with others based on their account type (developer, designer, company). By accessing and using this website, you accept these terms and conditions in full. If you disagree with these terms and conditions or any part of these terms and conditions, you must not use this website.</p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <div class="content">
                                <h3>User Accounts and Responsibilities</h3>
                                <p>When you create an account with us, you must provide accurate and complete information. You are responsible for maintaining the confidentiality of your account and password, including restricting access to your computer and account. You agree to accept responsibility for all activities that occur under your account.</p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="icon"><i class="fas fa-project-diagram"></i></div>
                            <div class="content">
                                <h3>Posting Projects and Vacancies</h3>
                                <p>Users with developer or designer accounts can post their projects and group project ideas on DevDo. Companies can post vacancies for various roles. By posting content on our platform, you grant us a non-exclusive, worldwide, royalty-free license to use, reproduce, adapt, publish, translate, and distribute it.</p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="icon"><i class="fas fa-users"></i></div>
                            <div class="content">
                                <h3>Collaboration and Workspaces</h3>
                                <p>When users send requests and their request is accepted, a workspace is created where they can collaborate via group chat and share files related to their projects. Users agree to use these workspaces responsibly and in accordance with our community guidelines.</p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="icon"><i class="fas fa-file-alt"></i></div>
                            <div class="content">
                                <h3>User Content and Intellectual Property</h3>
                                <p>Users retain ownership of the content they post on DevDo. By posting content, you grant us the right and license to use, modify, publicly perform, publicly display, reproduce, and distribute such content on and through the platform.</p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="icon"><i class="fas fa-ban"></i></div>
                            <div class="content">
                                <h3>Prohibited Activities</h3>
                                <p>You agree not to engage in any of the following prohibited activities: using the platform for any illegal purpose, violating our intellectual property rights, interfering with or disrupting the platform, etc.</p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                            <div class="content">
                                <h3>Limitation of Liability</h3>
                                <p>DevDo shall not be liable for any direct, indirect, incidental, consequential, or punitive damages arising out of your access to or use of the platform.</p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="icon"><i class="fas fa-shield-alt"></i></div>
                            <div class="content">
                                <h3>Indemnification</h3>
                                <p>You agree to indemnify and hold DevDo harmless from any claims, damages, losses, liabilities, costs, and expenses arising out of or in connection with your use of the platform or violation of these terms and conditions.</p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="icon"><i class="fas fa-gavel"></i></div>
                            <div class="content">
                                <h3>Governing Law</h3>
                                <p>These terms and conditions are governed by and construed in accordance with the laws of India.</p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="icon"><i class="fas fa-sync-alt"></i></div>
                            <div class="content">
                                <h3>Changes to Terms</h3>
                                <p>We reserve the right to modify or replace these terms and conditions at any time. By continuing to use DevDo after any revisions become effective, you agree to be bound by the revised terms.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* General Styles */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #0b0c10;
        color: #c5c6c7;
        margin: 0;
        padding: 0;

    }

    .terms-section {
        padding: 60px 0;
        
    }

    .terms-box {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        
    }

    .terms-header h2 {
        font-size: 1.8rem;
        color: #66fcf1;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .terms-header p {
        font-size: 1rem;
        color: #45a29e;
        margin-bottom: 20px;
    }

    .terms-content {
        text-align: left;
    }

    .section {
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
    }

    .section .icon {
        font-size: 1.5rem;
        color: #66fcf1;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .section .content {
        flex-grow: 1;
    }

    .terms-content h3 {
        font-size: 1.2rem;
        color: #66fcf1;
        margin-top: 0;
        margin-bottom: 10px;
    }

    .terms-content p {
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 10px;
    }
</style>
@endsection
