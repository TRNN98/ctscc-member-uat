<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('admin.layout.head')

    <script language="JavaScript">
        function chk_emtry() {
            if (document.form1.username.value == "") {
                alert("กรุณากรอกผู้ใช้งาน ! ");
                document.form1.username.focus();
                return false;
            }
            if (document.form1.password.value == "") {
                alert("กรุณากรอกรหัสผ่าน ! ");
                document.form1.password.focus();
                return false;
            }
            return true;
        }
    </script>

</head>

<body class="materialdesign">
    <div class="wrappersss">
        <!-- login Start-->
        <div class="login-form-area mg-t-30 mg-b-40">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <form id="adminpro-form" class="adminpro-form" name="form1" method="post"
                        action="{{ route('admin.login') }}" onSubmit="return chk_emtry();">
                        {{ csrf_field() }}
                        <div class="col-lg-4">
                            <div class="login-bg">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="logo">
                                            <a href="#"><img
                                                    src="{{ asset('admin/images/adminlogon/adminlogon_05.gif') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="login-input-head">
                                            <p>User</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="login-input-area">
                                            <input type="text" name="username" class="dot_field" id="username" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="login-input-head">
                                            <p>Password</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="login-input-area">
                                            <input type="password" name="password" class="dot_field" id="password" />
                                        </div>
                                        <!-- <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="forgot-password">
                                                        <a href="#">Forgot password?</a>
                                                    </div>
                                                </div>
                                            </div> -->
                                        {{-- <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="login-keep-me">
                                                        <label class="checkbox">
                                                            <input type="checkbox" name="remember" checked><i></i>Keep me logged in
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">

                                    </div>
                                    <div class="col-lg-8">
                                        <div class="login-button-pro">
                                            <!-- <button type="submit" class="login-button login-button-rg">Register</button> -->
                                            <button name="submit" id="submit" value="Login" type="submit"
                                                class="login-button login-button-lg">Log in.</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="col-lg-4"></div>
                </div>
            </div>
        </div>
        <!-- login End-->

    </div>
    @include('admin.layout.footer')

</body>

</html>
