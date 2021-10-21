<template>

 <Head title="Nova Enquete" />
<BreezeAuthenticatedLayout>


   <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                          <div class="container">

  <!-- Content here -->
  <div v-if="$page.props.flash.message"   class="alert alert-success alert-dismissible fade show" role="alert">
 {{ $page.props.flash.message }}
   <button type="button" class="btn-close" data-bs-dismiss="alert"  @click="$page.props.flash.message=null" aria-label="Close"></button>
</div>

    <Link v-bind:href="'pergunta/create'" :class="'btn btn-info'">criar nova Enquete</Link>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Enquete</th>
      <th scope="col">Data da publicação</th>
      <th scope="col ">Ação</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(pergunta , index) in perguntas" :key="pergunta.id">
      <th scope="row">{{index+1}}</th>
      <td>{{pergunta.nome}}</td>
      <td>{{pergunta.created_at}}</td>
      <td class=" py-0 align-middle">
         <div class="btn-group btn-group-sm">
             <Link v-bind:href="'pergunta/'+pergunta.id" :class="'btn btn-success btn-edit'">ver</Link>
             <Link v-bind:href="'pergunta/'+pergunta.id+'/edit'" :class="'btn btn-primary btn-edit'">editar</Link>
             <button class="btn btn-danger btn-delete" @click="eliminar(pergunta.id)">Apagar</button>
                 </div>
                </td>
    </tr>

  </tbody>
</table>

</div>
                    </div>
                </div>
            </div>
        </div>

</BreezeAuthenticatedLayout>

</template>
<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head , Link} from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';


export default {
    components:{
       BreezeAuthenticatedLayout,
       Head,
       Link
    },

    setup() {

    },
  props:{
      perguntas:Object
  },
  methods: {
     eliminar: function (id)
      {
         Inertia.delete('pergunta/'+id);
      },
  },
  created() {
var alertList = document.querySelectorAll('.alert')
var alerts =  [].slice.call(alertList).map(function (element) {
  return new bootstrap.Alert(element)
})
  },
  mounted() {

  },
}
</script>
