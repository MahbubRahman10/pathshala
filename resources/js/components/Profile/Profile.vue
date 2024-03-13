<template>
    <div>
        <Header></Header>
        <br><br><br>
        <div class="main-contents">

            <article v-if="notify" class="message is-primary">
                <div class="message-header">
                    <p>{{msg}}</p>
                </div>
            </article>

            <div class="columns">
              <div class="column">
                <img src="/images/user.png" class="image">
            </div>
            <div class="column myprofile">
                <h2>My Id : {{ userid }} </h2>
                <h2>Ussername : {{ username }} </h2>
                <h2>Fisrt Name : {{ firstname }} </h2>
                <h2>Last Name : {{ lastname }} </h2>
                <h2>Joined : {{ joindate }} </h2>
                <br><br>
                <a v-on:click="edit()" class="button is-info"><strong> Update Profile</strong> </a>
                <a v-on:click="changepassword()" class="button is-primary"><strong> Change Password</strong> </a>
            </div>
        </div>
        </div>

        <div class="modal"  v-bind:class="activeeditmodal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Update Profile</p>
                    <button class="delete" aria-label="close" v-on:click="deedit"></button>
                </header>
                <section class="modal-card-body">
                    <!-- Content ... -->
                    <form @submit.prevent="">
                        <br>
                        <div :class="{ 'has-error': errors.has('firstname') }">
                            <label class="control-label" for="firstname">First Name : </label><br>
                            <input v-validate="'required'" v-model="firstname" type="text" name="firstname" class="input">
                            <span v-show="errors.has('firstname')">{{ errors.first('firstname') }}</span>         
                        </div>
                        <br>
                        <div :class="{ 'has-error': errors.has('lastname') }">
                            <label class="control-label" for="lastname">Last Name : </label><br>
                            <input v-validate="'required'" v-model="lastname" type="text" name="lastname" class="input">
                            <span v-show="errors.has('lastname')">{{ errors.first('lastname') }}</span>         
                        </div>
                        <br>
                        
                        <br>
                    </form>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" v-on:click="editprofile">Save changes</button>
                    <button class="button" v-on:click="deedit">Cancel</button>
                </footer>
            </div>
        </div>

          <div class="modal"  v-bind:class="activepasswordmodal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Change Password</p>
                    <button class="delete" aria-label="close" v-on:click="dechangepassword"></button>
                </header>
                <section class="modal-card-body">
                    <!-- Content ... -->
                    <form @submit.prevent="">
                        <br>
                         <div :class="{ 'has-error': errors.has('oldpassword') }">
                            <label class="control-label" for="oldpassword">Old Password : </label><br>
                            <input v-validate="'required'" v-model="oldpassword" type="password" name="oldpassword" class="input">
                            <span v-show="errors.has('oldpassword')">{{ errors.first('oldpassword') }}</span>         
                        </div>
                        <br>
                        <div :class="{ 'has-error': errors.has('newpassword') }">
                            <label class="control-label" for="newpassword">New Password : </label><br>
                            <input v-validate="'required'" v-model="newpassword" type="password" name="newpassword" class="input">
                            <span v-show="errors.has('newpassword')">{{ errors.first('newpassword') }}</span>         
                        </div>
                        <br>
                        <div :class="{ 'has-error': errors.has('confirmpassword') }">
                            <label class="control-label" for="confirmpassword">confirm Password : </label><br>
                            <input v-validate="'required'" v-model="confirmpassword" type="password" name="confirmpassword" class="input">
                            <span v-show="errors.has('confirmpassword')">{{ errors.first('confirmpassword') }}</span>         
                        </div>
                        <br>
                        
                        <br>
                    </form>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" v-on:click="updatepassword">Save changes</button>
                    <button class="button" v-on:click="dechangepassword">Cancel</button>
                </footer>
            </div>
        </div>

        <br>
        <Footer></Footer>
        <vue-topprogress ref="topProgress"></vue-topprogress>
        
    </div>
</template>
<script>
    import Header from './../sections/header.vue'
    import Footer from './../sections/footer.vue'
    import { vueTopprogress } from 'vue-top-progress'
    import Modal from './Modal.vue'

    export default{
        components:{
            'Header' : Header,
            'Footer' : Footer,
            vueTopprogress,
            'Modal' : Modal 
        },
        data(){
            return{
                activeeditmodal: '',
                activepasswordmodal: '',
                notify : false, 
                nodata : false,
                username : '',
                firstname : '',
                lastname : '',
                oldpassword : '',
                newpassword : '',
                confirmpassword : '',
                userid : '',
                id : '',
                joindate : '',
                searchuser : '',
            }
        },
        methods:{
            getuser:function(value){
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/profiles',
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token'),
                }).then(response => {  
                    if(response.data != null){
                        this.username = response.data.data.UserName
                        this.firstname = response.data.data.FirstName
                        this.lastname = response.data.data.LastName
                        this.userid = response.data.data.UserId
                        this.id = response.data.data.id
                        this.joindate = response.data.data.JoinDate
                    }
                })
                .catch( error  => {
                
                });
            },            
            edit:function(index){
                this.activeeditmodal = 'is-active'
            },
            deedit:function(){
                this.activeeditmodal = ''
            },
            changepassword:function(index){
                this.activepasswordmodal = 'is-active'
            },
            dechangepassword:function(){
                this.activepasswordmodal = ''
            },
            editprofile() {
                var vm = this
                this.$validator.validateAll().then((result) => {
                    axios({
                        method: 'put',
                        url: 'http://localhost:8000/api/profiles/'+ this.id,
                        accept: 'json',
                        ContentType: 'json',
                        data: {
                            flag: 0,
                            username: vm.username,
                            firstname: vm.firstname,
                            lastname: vm.lastname
                        }
                    }).then(response => { 
                        this.notify = true
                        this.msg = 'Profile Update Successfully'
                        this.getuser()
                        vm.activeeditmodal = ''
                        setTimeout(function() { vm.notify = false }, 5000)
                    })
                    .catch( error  => {

                    });
                
                });
            },
            updatepassword() {
                var vm = this
                this.$validator.validateAll().then((result) => {
                    axios({
                        method: 'put',
                        url: 'http://localhost:8000/api/profiles/'+ this.id,
                        accept: 'json',
                        ContentType: 'json',
                        data: {
                            flag: 1,
                            current_password: vm.oldpassword,
                            password: vm.newpassword,
                            password_confirmation: vm.confirmpassword
                        }
                    }).then(response => { 
                        this.notify = true
                        this.msg = 'Password Update Successfully'
                        this.getuser()
                        vm.activepasswordmodal = ''
                        setTimeout(function() { vm.notify = false }, 5000)
                    })
                    .catch( error  => {

                    });
                
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
            this.getuser() 

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
   padding: 20px 20px;
-webkit-box-shadow: 10px 4px 6px 10px #777;
     -moz-box-shadow: 10px 4px 6px 10px #777;
          box-shadow: 10px 4px 6px 10px #777;
}


.columns{
    width:100% ;
    padding:10px 10px;
}


/* notifications after CRUD */
.notifications{
    text-align: center;
    margin-top: 10px;
    margin-left:10%;
}
.notifications span{
    background: #5f5f5f;
    color: #ffffff;
    font-size: 17px;
    border: 1px solid #cccccc;
    font-family: Verdana,sans-serif;
    padding: 5px 14px 10px 10px;
    overflow: visible;
    border-radius: 6px;
}
.nodata p{
    text-align: center;
    font-size: 20px;
    padding: 5px;
}

.create{
    padding: 7px 8px;
    color: white;
    border-radius: 3px;
    font-size:18px;
    font-weight:bold;
    border-color: white;
    background: #3e8ed0;
    margin:5px 15px;

}
.is-right {
    margin-top: 5px;
}
.create i{
    padding: 6px 5px;
    
}

.myprofile{
    margin-top: 30px;
    margin-left: 0px;
}

.image{
        margin-top: 30px;
    margin-left: 0px;
    border: 3px solid #2c333d;
}
.myprofile h2{
    padding: 5px 5px;
    font-weight: bold;
    font-size: 20px;
}

</style>
