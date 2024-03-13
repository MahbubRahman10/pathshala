<template>
	<div>

		<div class="modal" v-bind:class="activeaddmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Add New Class</p>
					<button class="delete" aria-label="close" v-on:click="deadd"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						<div :class="{ 'has-error': errors.has('classname') }">
							<label class="control-label" for="firstname">Class Name : </label><br> <br>
							<input v-validate="'required'" v-model="classname" type="text" name="classname" class="input">
							<span v-show="errors.has('classname')">{{ errors.first('classname') }}</span>         
						</div>
						<br>
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">					
					<button type="submit" class="button is-success" v-on:click="addclass">Submit</button>
					<button class="button" v-on:click="deadd">Cancel</button>
				</footer>
			</div>
		</div>

		<div class="modal"  v-bind:class="activeeditmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Update Class</p>
					<button class="delete" aria-label="close" v-on:click="deedit"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						<div :class="{ 'has-error': errors.has('classname') }">
							<label class="control-label" for="classname">Class Name : </label><br>
							<input v-validate="'required'" v-model="classname" type="text" name="classname" class="input">
							<span v-show="errors.has('classname')">{{ errors.first('classname') }}</span>         
						</div>
						<br>
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">
					<button class="button is-success" v-on:click="editclass">Save changes</button>
					<button class="button" v-on:click="deedit">Cancel</button>
				</footer>
			</div>
		</div>

		<div class="modal"  v-bind:class="activedeletemodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Remove Class</p>
					<button class="delete" aria-label="close" v-on:click="dedelete"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<p>Are you want to remove this class ?</p>
				</section>
				<footer class="modal-card-foot">
					<button type="submit" class="button is-danger" v-on:click="deleteclass">Delete</button>
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

				classid : '',
				classname : '',

				error: ''
			}
		},
		methods:{
			add:function(){
				this.activeaddmodal = 'is-active'
			},
			deadd:function(){
				this.activeaddmodal = ''
				this.classname = ''
				this.$validator.reset()
				this.errors.clear()
			},
			addclass() {
				var vm = this
				this.$validator.validateAll().then((result) => {
					if (result) {
						axios({
							method: 'post',
							url: 'http://localhost:8000/api/classes',
							accept: 'json',
							ContentType: 'json',
							data: {
								classname: vm.classname
							}
						}).then(response => { 
							vm.activeaddmodal = ''
							this.deadd()
							this.$emit('add-class');
						})
						.catch( error  => {
							vm.errors.add({
								field: 'classname',
								msg: 'classname is already in use'
							})
						});
					}
				});
			},
			edit:function(index,items){
				this.classid = items.id
				this.classname  = items.ClassName
				this.activeeditmodal = 'is-active'
			},
			deedit:function(){
				this.classid = ''
				this.classname = ''
				this.$validator.reset()
				this.errors.clear()
				this.activeeditmodal = ''
			},
			editclass() {
				var vm = this
				this.$validator.validateAll().then((result) => {
					axios({
						method: 'put',
						url: 'http://localhost:8000/api/classes/'+ this.classid,
						accept: 'json',
						ContentType: 'json',
						data: {
							classname: vm.classname
						}
					}).then(response => { 
						vm.activeeditmodal = ''
						this.$emit('edit-class');
					})
					.catch( error  => {
						vm.errors.add({
							field: 'classname',
							msg: 'classname is already in use'
						})
					});
				
				});
			},
			delete:function(index,id){
				this.activedeletemodal = 'is-active'
				this.classid = id
				this.index  = index
			},
			dedelete:function(){
				this.activedeletemodal = ''
			},
			deleteclass() {
				var vm = this
				axios({
					method: 'delete',
					url: 'http://localhost:8000/api/classes/'+ this.classid,
					accept: 'json',
					ContentType: 'json',
				}).then(response => { 
					vm.activedeletemodal = ''
					this.$emit('remove-class');
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