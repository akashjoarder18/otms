<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="" />
    <title></title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('assets/dist/assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/assets/css/style.bundle.css') }}">
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-white position-relative app-blank">
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Testimonials Section-->
        <div class="mt-20 mb-n20 position-relative z-index-2">

            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body p-0">
                        <!--begin::Wrapper-->
						<div class="text-center px-4">
							<img alt="Logo" src="{{ asset('assets/dist/assets/media/svg/logo/Logo_1.svg') }}"
                                    class="h-50px" />
						</div><br />
                        <div class="card-px text-center">
					
                            <!--begin::Title-->
                            <h2 class="fs-2x fw-bold mb-10">Email Verification Mail</h2>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <p class="text-gray-400 fs-4 fw-semibold mb-10">Please verify your email with bellow link:
                            </p>
                            @isset($password)
                                <!--begin::Description-->
                                <div class="fs-6 fs-lg-5 text-white fw-semibold opacity-75" style="color:white">
                                </div>
                                <p class="text-gray-400 fs-4 fw-semibold mb-10">After email
                                    varifications you can login by <br />username: {{ $username }} <br /> OR <br />
                                    email: {{ $email }},<br />password: {{ $password }}.<br /> Also changed your
                                    password
                                </p>
                                <!--end::Description-->
                            @endisset


                            <!--end::Description-->
                            <!--begin::Action-->
                            <a href="{{ route('user.verify', $token) }}" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_customer">Verify Email</a>
                            <!--end::Action-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Illustration-->
                        <div class="text-center px-4">
                            <img class="mw-100 mh-300px" alt=""
                                src="{{ asset('assets/dist/assets/media/illustrations/sketchy-1/2.png') }}" />
                        </div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->


        </div>
        <!--end::Root-->
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="{{ asset('assets/dist/assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/dist/assets/js/scripts.bundle.js') }}"></script>
        <!--end::Custom Javascript-->
        <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
