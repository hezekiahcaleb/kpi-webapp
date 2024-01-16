<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - KPI Monitoring App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="vh-100 px-4 py-5 px-md-5 text-center bg-dark text-lg-start">
        <div class="container h-100">
            <div class="row gx-lg-5 align-items-center h-100">
                <div class="col-lg-7 mb-5 mb-lg-0 text-white">
                    <h1>Performance <br/>
                        <span>Monitoring App</span>
                    </h1>
                    <p >
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Commodi ut error earum est quam delectus deleniti, officia quos provident consectetur placeat minus voluptatibus dolorum quas eligendi? Repudiandae molestiae adipisci delectus.
                    </p>
                </div>

                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="card">
                        <div class="card-body py-5 px-md-5">
                            <form action="login" method="POST">
                                @csrf
                                <div class="form-outline mb-3">
                                    <label class="form-label" for="email">Email address</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" required />
                                </div>
                                <div class="form-outline mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" required />
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input me-2" type="checkbox" id="remember" name="remember" checked />
                                    <label class="form-check-label" for="remember">
                                      Remember me
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block w-100">
                                    Login
                                </button>
                            </form>
                            @if (session()->has('loginError'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('loginError') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
