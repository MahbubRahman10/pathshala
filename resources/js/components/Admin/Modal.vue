<template>
	<div>

		<div class="modal" v-bind:class="activeaddmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Add New User</p>
					<button class="delete" aria-label="close" v-on:click="deadd"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						<div :class="{ 'has-error': errors.has('firstname') }">
							<label class="control-label" for="firstname">Username : </label><br>
							<input v-validate="'required'" v-model="username" type="text" name="username" class="input">
							<span v-show="errors.has('username')">{{ errors.first('username') }}</span>         
						</div>
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
						<div :class="{ 'has-error': errors.has('userrole') }" id="role">
							<label class="control-label" for="userrole">User Role : </label><br>
							<div class="select is-fullwidth">
								<select @change="selectrole" v-model="userrole">
									<option> Admin </option>
									<option> Teacher</option>
									<option> Pupils</option>
								</select>
							<span v-show="errors.has('userrole')">{{ errors.first('userrole') }}</span> 
							</div>
						</div><br>
						<div :class="{ 'has-error': errors.has('password') }">
							<label class="control-label" for="password">Password : </label><br>
							<input v-validate="'required|min:6'" v-model="password" type="password" name="password" class="input">
							<span v-show="errors.has('password')">{{ errors.first('password') }}</span>         
						</div>
						<br>
						
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">					
					<button type="submit" class="button is-success" v-on:click="adduser">Submit</button>
					<button class="button" v-on:click="deadd">Cancel</button>
				</footer>
			</div>
		</div>

		<div class="modal"  v-bind:class="activeeditmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Update User</p>
					<button class="delete" aria-label="close" v-on:click="deedit"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						<div :class="{ 'has-error': errors.has('username') }">
							<label class="control-label" for="username">Username : </label><br>
							<input v-validate="'required'" v-model="username" type="text" name="username" class="input">
							<span v-show="errors.has('username')">{{ errors.first('username') }}</span>         
						</div>
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
						
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">
					<button class="button is-success" v-on:click="edituser">Save changes</button>
					<button class="button" v-on:click="deedit">Cancel</button>
				</footer>
			</div>
		</div>

		<div class="modal"  v-bind:class="activedeletemodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Remove User</p>
					<button class="delete" aria-label="close" v-on:click="dedelete"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<p>Are you want to remove this user ?</p>
				</section>
				<footer class="modal-card-foot">
					<button type="submit" class="button is-danger" v-on:click="deleteuser">Delete</button>
					<button class="button" v-on:click="dedelete">Cancel</button>
				</footer>
			</div>
		</div>
	</div>
</template>

<script>
	
	
	export default{
		components: {
        
    	},
		data(){
			return{

				activeaddmodal: '',
				activeeditmodal: '',
				activeviewmodal: '',
				activedeletemodal: '',

				userid : '',
				username : '',
				firstname : '',
				lastname : '',
				password : '',
				userrole : '',

				userrole : 'Select Role',
                role : ''
			}
		},
		methods:{
			add:function(){
				this.activeaddmodal = 'is-active'
			},
			deadd:function(){
				this.activeaddmodal = ''
				this.username = ''
				this.firstname = ''
				this.lastname = ''
				this.userrole = ''
				this.password = ''
				this.$validator.reset()
				this.errors.clear()
			},
			selectrole:function() {
				if(this.userrole == 'Admin'){
					this.role = 1
				}
				else if(this.userrole == 'Teacher'){
					this.role = 2
				}
				else{
					this.role = 3
				}
			},
			adduser() {
				var vm = this
				this.$validator.validateAll().then((result) => {
					if (result) {
						axios({
							method: 'post',
							url: 'http://localhost:8000/api/auth/register',
							accept: 'json',
							ContentType: 'json',
							data: {
								username: vm.username,
								firstname: vm.firstname,
								lastname: vm.lastname,
								password: vm.password,
								password_confirmation: vm.password,
								role: vm.role
							}
						}).then(response => { 
							vm.activeaddmodal = ''
							this.deadd()
							this.$emit('add-user');
						})
						.catch( error  => {
							
						});
					}
				});
			},
			edit:function(index,items){
				this.userid = items.id
				this.username  = items.Username
				this.firstname = items.FirstName
				this.lastname  = items.LastName
				this.activeeditmodal = 'is-active'
			},
			deedit:function(){
				this.userid = ''
				this.username = ''
				this.firstname = ''
				this.lastname = ''
				this.userrole = ''
				this.password = ''
				this.$validator.reset()
				this.errors.clear()
				this.activeeditmodal = ''
			},
			edituser() {

				var vm = this
				this.$validator.validateAll().then((result) => {
					axios({
						method: 'put',
						url: 'http://localhost:8000/api/users/'+ this.userid,
						accept: 'json',
						ContentType: 'json',
						data: {
							username: vm.username,
							firstname: vm.firstname,
							lastname: vm.lastname
						}
					}).then(response => { 
						vm.activeeditmodal = ''
						this.$emit('edit-user');
					})
					.catch( error  => {

					});
				
				});
			},
			delete:function(index,id){
				this.activedeletemodal = 'is-active'
				this.userid = id
				this.index  = index
			},
			dedelete:function(){
				this.activedeletemodal = ''
			},
			deleteuser() {
				var vm = this
				axios({
					method: 'delete',
					url: 'http://localhost:8000/api/users/'+ this.userid,
					accept: 'json',
					ContentType: 'json',
				}).then(response => { 
					vm.activedeletemodal = ''
					this.$emit('remove-user');
				})
				.catch( error  => {

				});
			}
		},
		mounted(){

		}

	}

</script>

<style scoped="">
	

form span{
        padding: 3px 5px;
        color: #d9534f!important;
}
.has-error input{
        border-color: #d9534f!important;
}
.has-error textarea{
        border-color: #d9534f!important;
}

.modal-card-body span{
	margin-left: 10px;
}




</style>