@extends('layouts.app')

@section('content')
<section class="faq-section" style=" background: url('https://i.pinimg.com/originals/d6/c2/bc/d6c2bc5eef34797e9831992d76de249c.gif') ;
    background-size: cover; background-position: center;
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat; padding: 50px ; width: 80%; margin: auto;">
    <div class="container">
        <div class="card p-4" style="background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: none;">
            <div class="text-center mb-4">
                <h1 style="color: #AA336A;">Frequently Asked Questions</h1>
                <p>HOME / FAQ</p>
            </div>
            <div class="accordion" id="faqAccordion">
                <div class="card mb-3" style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: none; border-radius: 10px;">
                    <div class="card-header" id="headingOne" style="border: none;">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color: #AA336A">
                                <i class="fas fa-question-circle mr-2"></i> How can I create a profile?
                            </button>
                        </h2>
                    </div>
                
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                        <div class="card-body" style="background-color: #0a0f1a; color: #fff; border-radius: 0 0 10px 10px; padding: 15px;">
                            <p>To create a profile, click on the 'Sign Up' button and fill out the required information. Choose your account type as Developer, Designer, or Company based on your role.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: none; border-radius: 10px;">
                    <div class="card-header" id="headingTwo" style="border: none;">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color: #AA336A">
                                <i class="fas fa-question-circle mr-2"></i> How can I post my project?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                        <div class="card-body" style="background-color: #0a0f1a; color: #fff; border-radius: 0 0 10px 10px; padding: 15px;">
                            <p>To post a project, go to your profile dashboard and click on 'Create Project'. Fill in the details, including project title, description, and category (Developer, Designer, Company). Your project will be visible to other users based on its category.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: none; border-radius: 10px;">
                    <div class="card-header" id="headingThree" style="border: none;">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="color: #AA336A">
                                <i class="fas fa-question-circle mr-2"></i> How do group projects work for Developers and Designers?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                        <div class="card-body" style="background-color: #0a0f1a; color: #fff; border-radius: 0 0 10px 10px; padding: 15px;">
                            <p>Developers and Designers can collaborate on group projects by posting their ideas. Other users can send collaboration requests, and if accepted, a workspace will be created where team members can chat, share files, and work together.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: none; border-radius: 10px;">
                    <div class="card-header" id="headingFour" style="border: none;">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" style="color: #AA336A">
                                <i class="fas fa-question-circle mr-2"></i> How can Companies post vacancies?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                        <div class="card-body" style="background-color: #0a0f1a; color: #fff; border-radius: 0 0 10px 10px; padding: 15px;">
                            <p>Companies can post vacancies by navigating to their dashboard and clicking on 'Post Vacancy'. Fill in the details such as job title, description, requirements, and how to apply. Interested users can submit their resumes and photos directly through the platform.</p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" style="background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: none; border-radius: 10px;">
                    <div class="card-header" id="headingFive" style="border: none;">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" style="color: #AA336A">
                                <i class="fas fa-question-circle mr-2"></i> How do I contact support for assistance?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#faqAccordion">
                        <div class="card-body" style="background-color: #0a0f1a; color: #fff; border-radius: 0 0 10px 10px; padding: 15px;">
                            <p>If you need assistance, you can contact our support team through the 'Contact Us' page or directly through your profile dashboard. Our team will respond to your queries and provide necessary assistance promptly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="cta-section" style="background-color: #0a0f1a; color: #fff; padding: 50px 0; text-align: center; margin-top: 50px;">
    <div class="container">
        <h2>Let’s discuss and create something <span style="color: #AA336A;">amazing</span> together</h2>
        <a href="#" class="btn btn-primary" style="background-color: #AA336A; border: none;">Apply for a Meeting</a>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
@endsection
<style>
    body{
       
    }
</style>