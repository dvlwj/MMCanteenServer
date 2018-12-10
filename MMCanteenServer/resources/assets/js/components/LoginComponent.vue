<template>
	<div class="container">
		<div class="row justify-content-center">
	        <div class="col-md-10">
	            <div class="card">
	                <div class="card-header">Login</div>

	                <div class="card-body">
	                    <form method="POST" action="#">

	                        <div class="form-group row">
	                            <label for="username" class="col-sm-4 col-form-label text-md-right">Username</label>

	                            <div class="col-md-6">
	                                <input id="username" type="text" class="form-control" name="username" required autofocus>

	                                <!-- @if ($errors->has('email'))
	                                    <span class="invalid-feedback">
	                                        <strong>{{ $errors->first('email') }}</strong>
	                                    </span>
	                                @endif -->
	                            </div>
	                        </div>

	                        <div class="form-group row">
	                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

	                            <div class="col-md-6">
	                                <input id="password" type="password" class="form-control" name="password" required>

	                                <!-- @if ($errors->has('password'))
	                                    <span class="invalid-feedback">
	                                        <strong>{{ $errors->first('password') }}</strong>
	                                    </span>
	                                @endif -->
	                            </div>
	                        </div>

	                        <div class="form-group row mb-4">
	                            <div class="col-md-8 offset-md-4">
	                                <button type="submit" class="btn btn-primary">
	                                    Login
	                                </button>
	                            </div>
	                        </div>

	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</template>

<script>
	export default {
		name: "Login",
		mounted(){
			console.log("Mount LoginComponent!");
		}
	}
</script>