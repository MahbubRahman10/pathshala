<template>
    <div>
        <Header></Header>
         <div class="main-contents">

          

            <p class="utitle"> {{subjectname}} Subject - Result</p>
            <div class="field has-addons">
            </div>
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <tr>

                    <th scope="col">Pupils Username</th>
                    <th scope="col">Pupils Fisrt Name</th>
                    <th scope="col">Pupils Last Name</th>
                    <th scope="col">Pupils Average Grade</th>
                </tr>
                <tr v-if="results.data == ''">      
                    <td class="nodata" colspan='4' v-if="nodata"><p>No Subject Available</p></td>
                </tr>
                <tr v-if="loadings">
                    <td class="nodata" colspan='4'>
                        <div class="loading">
                            <p> <img src="https://jerickson.net/img/loading%20icon.png"></p>
                        </div> 
                    </td>
                </tr>
                <tr v-else v-for="(result,index) in results.data">
                  
                    <td>{{result.username }}</td>
                    <td> {{result.firstname }} </td>
                    <td> {{result.lastname }} </td>
                    <td>{{result.grade }}</td>             
                </tr>
            </table>
            <p> 
                <pagination :data="results" @pagination-change-page="getgrade">>
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </p>
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
                nodata : false,

                subjectname: '',
                subjectid :  this.$route.params.id,
                testname : '',
                results : {},
                loadings : false
            }
        },
        methods:{
            gettest:function(value) {
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/subjects/' + this.subjectid,
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token')
                }).then(response => {                  
                    this.subjectname = response.data.data.SubjectName
                })
                .catch( error  => {

                });
            },
            getgrade:function(page){
                var vm = this
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/tests?page=' + page,
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token')
                }).then(response => {  
                    if(response.data != null){
                        this.results = response.data
                        vm.loadings = false
                    }
                    else{
                        this.nodata = true
                    }
                })
                .catch( error  => {
                
                });
            }

           
        },
        mounted(){
            this.$refs.topProgress.start()
            var vm = this
            vm.loadings = true            
            setTimeout(() => {
                vm.loading = true,
                vm.$refs.topProgress.done()
            }, 500)
            this.gettest() 
            this.getgrade() 

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
}
.columns{
    width:100% ;
    padding:10px 10px;
}
.utitle {
    background: black;
    font-family: Arial, Helvetica, sans-serif;
    padding: 5px;
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 20px;
    color: white;
    box-shadow: 2px 2px #888888;
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

table{
    border: 1px solid #ddd
}

table thead th{
    border: 1px solid #ddd
}
table td{
    border: 1px solid #ddd;
}
table tr{
    border: 1px solid #ddd
}

.table.is-narrow td, .table.is-narrow th {
   padding: 0.7em 0.7em; 
}
.create{
    padding: 7px 8px;
    color: white;
    border-radius: 3px;
    font-size:18px;
    font-weight:bold;
    border-color: white;
    background: blue;
    margin:5px 15px;
}
.is-right {
    margin-top: 5px;
}
.create i{
    padding: 6px 5px;
    
}
</style>
