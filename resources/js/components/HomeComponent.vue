<template>
    <div class="container">
  <h2>Roy'hat</h2>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Ismi</th>
        <th>Familiyasi</th>
        <th>Rasmi</th>
        <th>Aktiv / Aktiv emas</th>
      </tr>
    </thead>
    
    <tbody>

        <tr v-for="(person, index) in people" :index="index" :key="person.id">
            <td>{{index+1}}</td>
            <td>{{person.name}}</td>
            <td>{{person.surname}}</td>
            <td> <img width="100" :src="'/uploads/' + person.picture"/></td>
            <td>

                <div class="form-group">
                    
                <toggle-button @change="changeStatus(person.id)" :value="person.is_active" v-model="person.is_active" 
                color="#3490dc"  />

                </div>
            </td>
        </tr>
      
    </tbody>
  </table>

    <h2>Yangi odam qoshish</h2>
  
    <form @submit.prevent="addPerson()">
    <div class="form-group">
        <label for="email">Ism:</label>
        <input class="form-control" v-model="form.name" type="text" name="name" placeholder="Ismni Kiriting">
        <div v-if="form.errors.has('name')" class="text-danger" v-html="form.errors.get('name')" />
    </div>
    <div class="form-group">
        <label for="email">Familiya:</label>
        <input class="form-control" v-model="form.surname" type="text" name="surname" placeholder="Familiyani Kiriting">
        <div v-if="form.errors.has('surname')" class="text-danger" v-html="form.errors.get('surname')" />
    </div>
    
    <div class="form-group">
        <label for="email">Rasmni Yuklang:</label>
        <input class="form-control-file border" v-on:change="onFileChange" type="file">
        <div v-if="form.errors.has('file')" class="text-danger" v-html="form.errors.get('file')" />
    </div>
    
    <div class="form-group form-check">
        <label class="form-check-label">
        <input class="form-check-input" v-model="form.is_active" type="checkbox"> Aktiv
        </label>
    </div>
    <button type="submit" class="btn btn-primary">Saqlash</button>
    </form>


</div>
</template>

<script>
    import Form from 'vform'
    
    export default {
        data(){
            return{
                people: {},
                form: new Form({
                    id:'',
                    name: '',
                    surname: '',
                    file: '',
                    is_active: '',
                })

            }

        },

        methods:{

            changeStatus(id){
                if (id !== '') 
                { 
                  this.form.id = id
                }
                this.form.post('api/change')
                .then(function(response){

                    if(response.data.status === 'success')
                    {
                        location.reload();
                      console.log("okk")
                    }
                })
                .catch(()=>{

                    // if failed
                    console.log("failed")
                })
                
            },

            onFileChange(e) {
                // console.log(e.target.files[0]);
                this.form.file = e.target.files[0];
            },
            loadPeople(){
                
                axios.get('api/people')
                    .then(({ data }) => (
                        this.people = data.people
                    ))
                    .catch(()=>{

                        // if failed
                        console.log("failed")
                    });
                    
            },

            addPerson(){
                this.form.post('api/addperson')
                .then(function(response){

                    if(response.data.status === 'success')
                    {
                        location.reload();
                        console.log('success')
                    }

                    if(response.data.status === 'error')
                    {
                        console.log('error')
                    }
                    
                })
                .catch(()=>{
                    // if failed
                    console.log('failed')
                })
                
            }

        },

        mounted() {
            this.loadPeople()
            
        }
    }
</script>
