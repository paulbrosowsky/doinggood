<template>
    <div>
        <dropzone
            id="dropzone" 
            ref="imageUpload"
            :options="dropzoneOptions"
            :useCustomSlot="true"          
            @vdropzone-files-added="setPreview"
            @vdropzone-error="getErrors"
            @vdropzone-success="completed"  
        >   
            <button class="btn" v-show="!image">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="280" r="63"/><path d="M440 96h-88l-32-32H192l-32 32H72c-22.092 0-40 17.908-40 40v272c0 22.092 17.908 40 40 40h368c22.092 0 40-17.908 40-40V136c0-22.092-17.908-40-40-40zM256 392c-61.855 0-112-50.145-112-112s50.145-112 112-112 112 50.145 112 112-50.145 112-112 112z"/></svg>
                <p>Bild ändern</p>
            </button>  
        </dropzone>

        <p class="text-sm text-red-500" v-text="error"></p>
        <div 
            v-if="image" 
            class="flex justify-center mt-2"            
        >
            <button class="btn" @click="cancel">               
                <span>abbrechen</span>
            </button>
            <button class="btn btn-yellow ml-2" @click="uploadImage" v-if="!error && !autoUpload">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M403.002 217.001C388.998 148.002 328.998 96 256 96c-57.998 0-107.998 32.998-132.998 81.001C63.002 183.002 16 233.998 16 296c0 65.996 53.999 120 120 120h260c55 0 100-45 100-100 0-52.998-40.996-96.001-92.998-98.999zM288 276v76h-64v-76h-68l100-100 100 100h-68z"/></svg>
                <span>hochladen</span>
            </button>
        </div>        
    </div>
</template>
<script>
    import Dropzone from 'vue2-dropzone'; 

    export default {

        components:{
            Dropzone           
        },

        props:{
            url:{
                type: String
            },
            autoUpload:{
                default: false
            },
            triggerUpload:{
                default:false
            }
        },

        data(){
            return{
                image: null,
                error: null,
            
                dropzoneOptions:{
                    url: this.url,
                    paramName: 'image',
                    uploadMultiple: false, 
                    // previewTemplate: this.template(),                   
                    // resizeWidth: 1280,
                    maxFilesize: 8, // max. size 8 MB                    
                    acceptedFiles: '.jpg,.jpeg,.png,.gif',                  
                    autoProcessQueue: false,  
                    previewsContainer: false,                                      
                    dictFileTooBig: 'Die Datei ist zu groß (max. 8MB)',
                    dictInvalidFileType: 'Kein gültiges Bildformat',  
                    headers: { 
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content  
                    },                                
                },               
            }
        },

        watch:{
            triggerUpload(){
                this.$refs.imageUpload.setOption('url', this.url);

                setTimeout(() => {
                    this.autoUpload ? this.uploadImage() : ''; 
                }, 500);                
            }
        },

        methods:{           

            setPreview(file){            
                this.image = file[0];  

                let reader = new FileReader();
                reader.onload = ()=>{
                    this.$emit('preview', reader.result);
                }                
                reader.readAsDataURL(file[0]);                   
            },

            getErrors(file, message, xhr){  
                // window.loading();            
                this.error = message.errors.image[0];             
            },

            cancel(){
                this.$refs.imageUpload.removeAllFiles();
                this.error = null;  
                this.image = null;                
                this.$emit('cancel');
            },

            uploadImage(){
                this.$refs.imageUpload.processQueue();
                window.loading();
            },

            completed(){
                this.$refs.imageUpload.removeAllFiles();
                this.error = null;  
                this.image = null;
                window.loading();  
                window.location.reload();
                this.$emit('complete');
            }
            
        }
    }
</script>
