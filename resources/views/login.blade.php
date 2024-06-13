<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
<section class="vh-100" style="background-image: url(background.jpg);">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block" style="background-color: white;">
              <!-- <img src="{{asset('background3.jpg')}}" width="500px" height="500px"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" /> -->
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
              @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $item)
                    <li>
                        {{$item}}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
              <form action="{{route('login.auth')}}" method="POST">
              @csrf
                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">Login </span>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                      <label class="form-label" for="form2Example17">Email address</label>
                    <input type="email" id="form2Example17" name="email" class="form-control form-control-lg" />
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                      <label class="form-label" for="form2Example27">Password</label>
                    <input type="password" id="form2Example27" name="password" class="form-control form-control-lg" />
                  </div>

                  <div class="pt-1 mb-4">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                  </div>
                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Belum punya account? 
                    <a href="{{route('register_account')}}"style="color: #393f81;">Daftar disini</a></p>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    
    </div>
</body>
</html>