<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.auth.user" href="/pergunta" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">


            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">

                <div v-for="pergunta in perguntas"  :key="pergunta.id" class="card">
                <div class="card-header">
                   {{pergunta.nome}}
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="respota in pergunta.respostas" :key="respota.id" >

                       <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" @click="changPercetagem(pergunta.id, respota.id)"  >
                        <label class="form-check-label" for="flexRadioDefault1">
                          {{respota.nome}}
                        </label>
                         <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" v-bind:id="respota.id"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">  </div>
                        </div>
                        </div>
                     </li>
                    </ul>
                   </div>
                </div>

                </div>
            </div>


        </div>
    </div>
</template>

<style scoped>
    .bg-gray-100 {
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
    }

    .border-gray-200 {
        border-color: #edf2f7;
        border-color: rgba(237, 242, 247, var(--tw-border-opacity));
    }

    .text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }

    .text-gray-500 {
        color: #a0aec0;
        color: rgba(160, 174, 192, var(--tw-text-opacity));
    }

    .text-gray-600 {
        color: #718096;
        color: rgba(113, 128, 150, var(--tw-text-opacity));
    }

    .text-gray-700 {
        color: #4a5568;
        color: rgba(74, 85, 104, var(--tw-text-opacity));
    }

    .text-gray-900 {
        color: #1a202c;
        color: rgba(26, 32, 44, var(--tw-text-opacity));
    }

    @media (prefers-color-scheme: dark) {
        .dark\:bg-gray-800 {
            background-color: #2d3748;
            background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
        }

        .dark\:bg-gray-900 {
            background-color: #1a202c;
            background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
        }

        .dark\:border-gray-700 {
            border-color: #4a5568;
            border-color: rgba(74, 85, 104, var(--tw-border-opacity));
        }

        .dark\:text-white {
            color: #fff;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
        }

        .dark\:text-gray-400 {
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--tw-text-opacity));
        }
    }
</style>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
    components: {
      Head,
      Link,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        perguntas:Object
    },
    data() {
        return {
            percetagem:{}
        }
    },

    methods: {

        refreshPercetagem: function () {
            axios.get('/api/respostavotos')
            .then(({data})=>{

            for (let i = 0; i < data.respostas.length; i++) {
                let progressbar = document.getElementById(data.respostas[i].id);
                 progressbar.style.width = data.respostas[i].percetagem+'%';
                 progressbar.innerText= data.respostas[i].percetagem+'%';
            }

            });
        },
        changPercetagem: function (id_pergunta, id_resposta) {

            let progressbar = document.getElementById(id_resposta);


          axios.post('/api/respostavotos',{
               'id_pergunta':id_pergunta,
               'id_resposta':id_resposta
            }).then(({data})=>{
            progressbar.style.width = data.percetagem+'%';
            progressbar.innerText= data.percetagem+'%';
              this.$forceUpdate();
            })

        }
    },
    mounted() {
        for (let index = 0; index < this.perguntas.length; index++) {
            for (let i = 0; i < this.perguntas[index].respostas.length; i++) {
                let progressbar = document.getElementById(this.perguntas[index].respostas[i].id);
                 progressbar.style.width = this.perguntas[index].respostas[i].percetagem+'%';
                 progressbar.innerText= this.perguntas[index].respostas[i].percetagem+'%';
            }

        }
    },

    updated() {

    },
}
</script>
