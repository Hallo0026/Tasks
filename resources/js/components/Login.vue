<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form method="POST" action="" @submit.prevent="login($event)">

                            <input type="hidden" name="_token" :value="csrfToken">

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" v-model="email" class="form-control" name="email" value="" required autocomplete="email" autofocus>

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Mensagem</strong>
                                    </span>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="password" class="form-control" name="password" required autocomplete="current-password">

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Mensagem</strong>
                                    </span>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                            Manter-me logado
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="">
                                        Esqueceu sua senha?
                                    </a>

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
    import axios from 'axios';

    export default {
        props: ['csrfToken'],
        data() {
            return {
                email: '',
                password: ''
            };
        },
        methods: {
            login(e) {

                const url = 'api/auth/v1/login';
                const data = {
                    email: this.email,
                    password: this.password
                };

                axios.post(url, data)
                    .then(response => {
                        console.log(response.data);
                        const token = response.data.token;
                        if(token) {
                            localStorage.setItem('token', response.data.token);
                        }

                        e.target.submit();

                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            }
        }
    }
</script>

