<template>
  <div>
    <nav class="navbar" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        
          <p class="navbar-title">Pathshala</p>
        

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div v-if="token != 'null'" id="navbarBasicExample" class="navbar-menu">
        <div v-if="role == 'Admin'" class="navbar-start">
          <router-link to="/admin/users" class="navbar-item"></i>   Home </router-link>
          <router-link to="/admin/classes" class="navbar-item"></i>   Classes </router-link>
          <router-link to="/admin/subjects" class="navbar-item"></i>   Subjects </router-link>
        </div>
        <div v-if="role == 'Teacher'" class="navbar-start">
          <router-link to="/teacher/index" class="navbar-item"></i>   Home </router-link>
          <router-link to="/user/profile" class="navbar-item"></i>   Profile </router-link>
          <a v-on:click="logout()" class="navbar-item router-link-active"> Logout </a>
        </div>
        <div v-if="role == 'Pupil'" class="navbar-start">
          <router-link to="/pupils/subjects" class="navbar-item"></i>   Home </router-link>
          <router-link to="/user/profile" class="navbar-item"></i>   Profile </router-link>
          <a v-on:click="logout()" class="navbar-item router-link-active"> Logout </a>
        </div>

        <div v-if="token != 'null' && role == 'Admin'" class="navbar-end">
          <div class="navbar-item">
            <div class="buttons">
              <router-link to="/user/profile" class="button profile"><i class="fa fa-user"></i>   <strong>Profile</strong> </router-link>
              
              <a v-on:click="logout()" class="button logout"><i class="fa fa-sign-out"></i> 
                <strong> Logout</strong>
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>


</template>

<script >
  
  export default{
    data(){
      return{
        data : '',
        token : '',
        role : ''
      }
    },
    methods:{
      getauser:function() {
          this.token = this.$cookie.get('token');
          this.role = this.$cookie.get('role');
      },
      logout:function() {
          this.$cookie.set('token', null);
          this.$router.push({ path : '/' });
      },
    },
    mounted(){
      this.getauser()
    }
  }

</script>


<style scoped>
nav.navbar {
  background: #37423c;
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
}
a.navbar-item {
  color: white;
  font-weight: bold;
}
a.navbar-item:hover {
  color: black;
  font-weight: bold;
}

.navbar-title{
  color: white;
  font-size: 20px;
  font-weight: bold;
  text-shadow: -1px -1px 0px rgba(255,255,255,255), 1px 1px 0px rgba(255,255,255,255);
  opacity: 0.9;
  font: 200 30px 'White';
  align-items: center;
  display: flex;
  margin-left: 15px;
  margin-right: 10px;
  
}

.logout strong{
  padding: 3px;
  margin-top: -5px;
}

.profile strong{
  padding: 5px;
  margin-top: -3px;
}


</style>