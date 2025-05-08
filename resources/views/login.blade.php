<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css">
    <!-- End layout styles -->
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h2 class="card-title text-left mb-3">Logowanie</h2>
                <form method="post" action="{{ route('login.process') }}">
                    @csrf
                    <div class="form-group">
                    <label>Nazwa użytkownika lub email*</label>
                    <input type="text" name="usernameAndEmail" id = "usernameAndEmail" class="form-control p_input" value="{{ old('usernameAndEmail') }}">
                  </div>
                  <div class="form-group">
                    <label>Hasło *</label>
                    <input type="password" name="password" id="password" class="form-control p_input">
                  </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="border-left: 4px solid #dc3545; background-color: #fff0f1;">
                            <i class="mdi mdi-alert-circle-outline text-danger mr-3" style="font-size: 1.8rem;"></i>
                            <div>
                                <h6 class="font-weight-bold mb-2 text-danger">Oops! Coś poszło nie tak</h6>
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="close ml-auto" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" class="mdi mdi-close text-danger"></span>
                            </button>
                        </div>
                    @endif

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Zaloguj się</button>
                  </div>
                  <p class="sign-up">Nie masz konta?<a href="{{ route('register') }}">  Zarejestruj się</a></p>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>
