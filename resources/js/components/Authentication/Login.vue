<template>
    <div>
        <Header></Header>
        <div class="main-contents">
            <div class="login">
                <div class="column">
                    <p class="ltitle">Login</p>
                    <p v-if="activeerror" id="activeerror">Upss! Username and password does not match</p>
                    <form @submit.prevent="">
                        <div class="field">
                            <label class="label">Username</label>
                            <div class="control">
                                <input v-validate="'required'" v-model="username" class="input iusername" type="text" placeholder="Username" name="username" >
                            </div>
                             <span class="error" v-show="errors.has('username')">{{ errors.first('username') }}</span>
                        </div>
                        <div class="field">
                          <label class="label">Password</label>
                            <div class="control">
                                <input v-validate="'required'" v-model="password" class="input pusername" type="password" placeholder="password" name="password">
                             </div>
                            <span class="error" v-show="errors.has('password')">{{ errors.first('password') }}</span>
                        </div>
                        <button class="button is-link" v-on:click="Submitlogin">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <Footer></Footer>
        <vue-topprogress ref="topProgress"></vue-topprogress>
    </div>
</template>
<script>
    import Header from './../sections/header.vue'
    import Footer from './../sections/footer.vue'
    import { vueTopprogress } from 'vue-top-progress'
    export default{
        components:{
            'Header' : Header,
            'Footer' : Footer,
            vueTopprogress
        },
        data(){
            return{
                activeerror : false,
                username: '',
                password: '',
                token : '',
                role : ''
            }
        },
        methods:{
            Submitlogin() {
                var vm = this
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios({
                            method: 'post',
                            url: 'http://localhost:8000/api/auth/login',
                            accept: 'json',
                            ContentType: 'json',
                            data: {
                                username: vm.username,
                                password: vm.password
                            }
                      }).then(response => {  
                        vm.token = response.data.token;
                        vm.role = response.data.role;
                        this.$cookie.set('token',vm.token);
                        this.$cookie.set('role',vm.role);
                        if (response.data.role == 'Admin') {
                            this.$router.push({ path : '/admin/users' })
                        }
                        else if(response.data.role == 'Teacher'){
                            this.$router.push({ path : '/teacher/index' });
                        }
                        else{
                            this.$router.push({ path : '/pupils/subjects' });
                        }
                        
                      })
                      .catch( error  => {
                       if (error.request.status == 401) {
                        vm.activeerror = true
                        vm.username = ''
                        vm.password = ''
                        vm.$validator.reset()
                        vm.errors.clear()
                       }
                    });
                  }
              });
            }
        },
        mounted(){
            this.$refs.topProgress.start()
            var vm = this            
            setTimeout(() => {
                vm.loading = true,
                vm.$refs.topProgress.done()
            }, 500) 
        }
    }
</script>

<style scoped>
span.error {
  color: #9F3A38;
}
#activeerror{
    background: #9F3A38;
    color: white;
    font-size: 15px;
    font-weight: bold;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}
.main-contents{
   margin-top: 0;
   margin: 5% 20% 10% 20%;
   padding: 10;
   padding: 130px 170px;
   box-shadow: 2px 7px #888888;
   border: 1px solid #69665e;
}
.columns{
    width:100% ;
    padding:10px 10px;
}
.ltitle {
    background: #50a16a;
    font-family: Arial, Helvetica, sans-serif;
    padding: 5px;
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 20px;
    color: white;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;

}
</style>
