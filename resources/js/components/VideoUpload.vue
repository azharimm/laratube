<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload</div>

                    <div class="card-body">
                        <input type="file" id="video" name="video" @change="fileInputChange" v-if="!uploading">
                        <div class="alert alert-danger" v-if="failed">
                            Something went wrong. Please try again
                        </div>

                        <div id="video-form" v-if="uploading && !failed">

                            <div class="alert alert-info" v-if="!uploadingComplete">
                                Your video will be available at <a target="_blank" :href="laratube.url+'/videos/'+uid">{{laratube.url}}/videos/{{uid}}</a>
                            </div>
                            <div class="alert alert-success" v-if="uploadingComplete">
                                Upload complete, your video is now processing. <a href="/videos">Go to your video</a>
                            </div>
                            <div class="progress mb-3" v-if="!uploadingComplete">
                                <div class="progress-bar" :style="{width: fileProgress+'%'}"></div>
                            </div>
                            
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" v-model="title">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" v-model="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Visibility</label>
                                <select class="form-control" v-model="visibility">
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>
                            <span class="help-block pull-right">{{saveStatus}}</span>
                            <button class="btn btn-primary" type="submit" @click.prevent="update">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return{
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                uploading :false,
                uploadingComplete :false,
                failed :false,
                title :'Untitle',
                description :null,
                visibility :'private',
                file :null,
                uid :null,
                saveStatus :null,
                fileProgress: 0
            }
        },
        mounted(){
            window.onbeforeunload = ()=>{
                if(this.uploading && !this.uploadingComplete && !this.failed){
                    return 'Are you sure you want to navigate away?'
                }
            }
        },
        methods:{
            fileInputChange(){
                this.uploading = true;
                this.failed = false;

                this.file = document.getElementById('video').files[0];

                //store the meta data
                
                this.store().then(()=>{
                    //upload video
                    var form = new FormData();
                    form.append('video', this.file);
                    form.append('uid', this.uid);
                    form.append('_token', this.csrf);
                    this.$http.post('/upload', form, {
                        progress: (e) =>{
                            if(e.lengthComputable){
                                console.log(e.loaded + ' '+ e.total);
                                this.updateProgress(e);
                            }
                        }
                    }).then(()=>{
                        this.uploadingComplete = true;
                    }, ()=>{
                        this.failed = true;
                    });
                }, ()=>{
                    this.failed = true;
                });
            },
            store(){
                return this.$http.post('/videos', {
                    title : this.title,
                    description : this.description,
                    visibility : this.visibility,
                    extension : this.file.name.split('.').pop(),
                    _token : this.csrf
                })
                .then((response)=>{
                    this.uid = JSON.parse(response.bodyText).data.uid;
                });
            },
            update(){
                this.saveStatus = 'Saving Changes.';
                return this.$http.put('/videos/'+this.uid, {
                    title : this.title,
                    description : this.description,
                    visibility : this.visibility,
                    _token : this.csrf
                }).then((response)=>{
                    this.saveStatus = 'Changes saved.';
                    setTimeout(()=>{
                        this.saveStatus = null;
                    }, 2000); 
                }, ()=>{
                    this.saveStatus = 'Failed to save changes.';
                });
            },
            updateProgress(e){
                e.percent = (e.loaded / e.total) * 100;
                this.fileProgress = e.percent;
            }
        }
    }
</script>

<style scoped>
    .pull-right{
        float: right!important;
    }
</style>
