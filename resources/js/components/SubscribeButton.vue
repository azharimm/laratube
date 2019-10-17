<template>
	<div class="subscribe-button" v-if="subscribers != null">
		 <button class="btn btn-sm btn-danger" type="button" v-if="canSubscribe" @click.prevent="handle">{{userSubscribed ? 'Unsubscribe' : 'Subscribe'}}</button>
		 &nbsp; <small>{{subscribers}} subscribers</small> 
	</div>
</template>

<script>
	export default{
		data(){
			return{
				subscribers:null,
				userSubscribed : false,
				canSubscribe : false
			}
		},
		props:{
			channelSlug:null
		},
		methods:{
			getSubscriptionStatus(){
				this.$http.get(`/subscription/${this.channelSlug}`)
				.then((response) =>{
					this.subscribers = JSON.parse(response.bodyText).count;
					this.userSubscribed = JSON.parse(response.bodyText).user_subscribed;
					this.canSubscribe = JSON.parse(response.bodyText).can_subscribe;
				})
			},
			handle(){
				if(this.userSubscribed){
					this.unSubscribe();
				}else{
					this.subscribe();
				}
			},
			subscribe(){
				this.userSubscribed = true;
				this.subscribers++;
				this.$http.post(`/subscription/${this.channelSlug}`, {_token:this.csrfToken});
			},
			unSubscribe(){
				this.userSubscribed = false;
				this.subscribers--;
				this.$http.delete(`/subscription/${this.channelSlug}`,{_token:this.csrfToken});
			}
		},
		mounted(){
			this.getSubscriptionStatus();
		}
	}
</script>