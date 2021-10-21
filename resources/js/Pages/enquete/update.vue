<template>

 <Head title="Nova Enquete" />
<BreezeAuthenticatedLayout>

<div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                         <div class="container">
                    <!-- Content here -->
                    <div v-if="$page.props.flash.message"   class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $page.props.flash.message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"  @click="$page.props.flash.message=null" aria-label="Close"></button>
                        </div>

                    <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label for="pergunta" class="form-label">Pergunta</label>
                        <input type="text" class="form-control" id="pergunta"   v-model="form.pergunta"   >

                    </div>
                    <div class="mb-3">
                        <label for="resposta" class="form-label">Respostas</label>
                        <input  v-for="i in respostas" :key="i" type="text" class="form-control" id="resposta" v-model="form.resposta[i-1]"  >
                    </div>
                    <div class="mb-3 ">

                    <a @click="maisResposta()"  class="btn btn-success">+  Alternativa</a>
                    <a @click=" menosResposta()" class="btn btn-danger">- Alternativa</a>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>

                    </form>

                    </div>
                    </div>
                </div>
            </div>
        </div>


</BreezeAuthenticatedLayout>

</template>
<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , usePage} from '@inertiajs/inertia-vue3';
import {reactive, computed  } from 'vue';

import { Inertia } from '@inertiajs/inertia';


export default {
    components:{
       BreezeAuthenticatedLayout,
       Head
    },

    setup() {

        const  form = reactive({
                pergunta: '',
                resposta:[],
            })
        const p = computed(() => usePage().props.value.pergunt.id)

            function submit() {
                Inertia.put('/pergunta/'+p.value,form);
            }
            return {form, submit}
    },
    props:{
      pergunt:Object,
      resposts:Object
  },
    data() {
        return {
          respostas:2,
          per:this.pergunt.nome
        }
    },

    methods: {

        maisResposta()
        {
            if (this.respostas < 10) {
               this.respostas++

            }
        },

        menosResposta()
        {
            if (this.respostas > 2) {
                      this.respostas--
            }
        },


    },
 mounted()   {
      this.form.pergunta = this.pergunt.nome;

    this.respostas = this.resposts.length;
       this.form.resposta.splice(this.resposts.length);
      for (let index = 0; index < this.resposts.length; index++) {

            //this.$set(this.form.resposta,index,this.resposts[index].nome);
         //this.form.resposta.splice(index,index,this.resposts[index].nome);
         this.form.resposta.push(this.resposts[index].nome);

      }

  },
}
</script>
