<template>
    <div>
        <Header></Header>
        <div class="main-contents">
            <div class="login">
                <div class="column">
                    <p class="ltitle">Update Test</p>
                   
                    <form @submit.prevent="">
                        <div :class="{ 'has-error': errors.has('testname') }">
                            <label class="control-label" for="firstname">Test Name : </label><br>
                            <input v-validate="'required'" v-model="testname" type="text" name="testname" class="input">
                            <span id="activeerror" v-show="errors.has('testname')">{{ errors.first('testname') }}</span>         
                        </div>
                        <br>
                        <div :class="{ 'has-error': errors.has('testdate') }">
                            <label class="control-label" for="testdate">Test Date : </label><br>
                            <input v-validate="'required'" v-model="testdate" type="date" name="testdate" class="input">
                            <span id="activeerror" v-show="errors.has('testdate')">{{ errors.first('testdate') }}</span>         
                        </div>
                        <br>
                        <br>
                        <button class="button is-info" v-on:click="edittest">Update</button>
                        <br>
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
                
                testname : '',
                testdate : '',
                testid :  this.$route.params.id,
                subjectid : '',
                message : ''

            }
        },
        methods:{
            selectrole:function() {
                if(this.userrole == 'Admin'){
                    this.role = 1
                }
                else if(this.userrole == 'Admin'){
                    this.role = 2
                }
                else{
                    this.role = 3
                }
            },
            gettest(){
               var vm = this
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/tests/'+vm.testid,
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token'),
                }).then(response => {
                   vm.testname = response.data.data.TestName
                   vm.testdate = response.data.data.TestDate
                })
                .catch( error  => {

                });
            },
            edittest() {
                var vm = this
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios({
                            method: 'put',
                            url: 'http://localhost:8000/api/tests/'+vm.testid,
                            accept: 'json',
                            ContentType: 'json',
                            Authorization: 'Bearer' + this.$cookie.get('token'),
                            data: {
                                name: vm.testname,
                                date: vm.testdate
                            }
                        }).then(response => {
                            this.$cookie.set('message','Test Updated Successfully');
                            this.$router.back();
                        })
                        .catch( error  => {
                            
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

            this.gettest()
        }
    }
</script>

<style scoped>
span.error {
  color: #9F3A38;
}
#activeerror{
 
    color: #9F3A38;
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
    background: #325c4b;
    font-family: Arial, Helvetica, sans-serif;
    padding: 5px;
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 20px;
    color: white;
    box-shadow: rgb(0 0 0 / 24%) 0px 3px 8px;
}
</style>
