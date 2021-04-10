<template>
    <div class="index">
        <div class="masthead d-flex">

            <div class="container text-center my-auto">
                <h1 class="mb-1">Administrador de productos</h1>
                <h3 class="mb-5">
                    <em>Gestión de productos de Baja PC Gamer</em>
                </h3>
                <a href="/login" class="btn btn-primary">Inicia Sesión</a>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            //console.log('Component mounted.')
        }
    }
</script>

<style>

    .index {
        width: 100vw;
        height: 100vh;
    }

    .masthead {
        color:#031B40;
        min-height: 30rem;
        width: 100%;
        height: 100%;
        padding-top: 8rem;
        padding-bottom: 8rem;
        /*background: url('https://e00-marca.uecdn.es/assets/multimedia/imagenes/2020/02/21/15822734764207.jpg');*/
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .masthead h1 {
        font-size: 4rem;
        margin: 0;
        padding: 0;
    }
    
    @media (min-width: 992px) {
        .masthead {
            height: 100vh;
        }
        .masthead h1 {
            font-size: 5.5rem;
        }
    }

</style>
