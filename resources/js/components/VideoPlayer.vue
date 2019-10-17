<template>
	<video 
	id="video" 
	class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" 
	controls preload="auto" 
	data-setup='{"fluid":true, "preload":"auto"}'
	:poster="thumbnailUrl">
		<source type="video/mp4" :src="videoUrl"></source>
	</video>
</template>

<script>
import videjs from 'video.js';
export default{
	data(){
		return{
			player : null
		}
	},
	props:{
		videoUid: null,
		videoUrl: null,
		thumbnailUrl: null
	},
	mounted(){
		this.player = videjs('video');
		this.player.on('loadedmetadata', ()=>{
			this.duration = Math.round(this.player.duration());
		});

		setInterval(()=>{
			if(this.hasHitQuotaView()){
				console.log('log a view');
				this.createView();
			}
		},1000)
	},
	methods:{
		hasHitQuotaView(){
			if(!this.duration){
				return false;
			}
			return Math.round(this.player.currentTime()) === Math.round((10 * this.duration) /100);
		},
		createView(){
			this.$http.post('/videos/'+this.videoUid+'/views', {
				_token:this.csrfToken
			});
		}
	}
}
</script>
<style>
	
</style>