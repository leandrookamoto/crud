<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
<script async src="https://unpkg.com/axios/dist/axios.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

      </head>
    <body>
<div>
    
</div>
      <main id='app'>

<section style='width: 40%; margin: 50px auto; border: 1px solid black; padding: 30px'>
<div style='font-weight: bolder; font-size: 30px; margin-bottom: 20px'>Todo List</div>
  <div class="input-group mb-3" v-if='!edit'>
    <input type="text" class="form-control" placeholder="Todo List" aria-label="Recipient's username" aria-describedby="button-addon2" v-model= 'description'>
    <button class="btn btn-outline-secondary" type="button" id="button-addon2" @click="gravar">Gravar</button>
    <button class="btn btn-outline-secondary" type="button" id="button-addon2" @click='this.edit=true'>Ver Lista</button>
  </div>

  <div v-if='edit'>
    <p v-for='(item,index) in todoList' key='index' style='border-bottom: 1px solid black; display: flex; justify-content: space-between'>
      @{{item.description}}
      <span>
        <svg @click='editar(index)' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg>
      <svg @click='apagar(index)' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
</svg>

      </p>
    <button type="button" class="btn btn-outline-secondary" @click='voltar'>Voltar</button>
      </div>
    
  </span>
</section>

</main>




<script src="https://unpkg.com/vue@3.0.4"></script>
<script>

    const { createApp } = Vue
    createApp({
    data() {
      return {
        description: '',
        todoList:[],
        edit: false,
        index:null,
        list: {},
        id: null,
      }
    },
    created(){
      fetch(`/description`).then(response=>response.json()).then((data)=>{
        this.todoList=data?data:[];  
        let comprimento = data.length-1;
        let novaData = data[comprimento].id;
        this.id=data?novaData:null;
        
      });

    },


    methods:{
      gravar(){

      if(this.list.id){
          const index = this.todoList.findIndex((item)=>item.id===this.list.id);

          this.todoList[index] = this.list;
          this.list.description=this.description;
          this.index=null;

          axios
          .put(`/description/${this.list.id}`, {
            description: this.list.description
  
          });

      }else{

          this.id=this.id+1;
          this.todoList.push({description: this.description, id: this.id});
          console.log(this.todoList)
          axios.post('/description', {description: this.description}, { headers: {
        
            'content-type': 'application/json'
          }})
          .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
            console.log(error);
          });
              }
      this.edit=true;
      },

      voltar(){
        this.edit=false;
        this.description='';
        this.list={};
      },

      editar(index){
        this.description=this.todoList[index].description;
        this.list=this.todoList[index];
        this.edit=false;
      },

      apagar(index){
        const lista = this.todoList[index];

    //  fetch(`/descriptiondelete/${lista.id}`, { method: 'DELETE' })
        axios.delete(`/descriptiondelete/${lista.id}`)
        
        this.todoList.splice(index,1);

      },
      },

  }).mount('#app')

 
</script>
    </body>
</html>
