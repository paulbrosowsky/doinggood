<template>
    <div class="w-full">

        <div class="relative bg-gray-500 rounded-xl overflow-hidden pb-2/3 mb-5 mx-5 md:mx-0 ">           
            <img class="absolute w-full h-full object-cover" :src="imageSrc" alt="">
        </div>

        <div class="flex justify-center mb-5">
            <image-upload                    
                :url="imageUploadUrl"
                :auto-upload="true"
                :trigger-upload="uploadImage"
                @preview="showPreview"
                @cancel="removePreview"
                @complete="redirectToNeed"
            ></image-upload>
        </div>        

        <div class="container mb-5 md:rounded-xl"> 
            <h4 class="text-gray-500 mb-5">Welche Art von Untestüzung braucht ihr?</h4>
            <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.categories">{{errors.categories[0]}}</p>
            <category-select                 
                :categories="categories"                                  
                @update="updateCategories"
            ></category-select> 
        </div>

        <form @submit.prevent="createNeed">
            <div class="container mb-5 md:rounded-xl">
            
                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Überschrift</label>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.title">{{errors.title[0]}}</p>
                    <div class="input mt-1">                        
                        <input class="px-3"
                            type="text"
                            name="title"
                            v-model="form.title"
                            required 
                            placeholder="Überschrift"
                        >
                    </div>
                </div>

                <div class="mb-2">
                    <label class="text-gray-500 text-sm font-semibold ml-2">Deadline</label>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.deadline">{{errors.deadline[0]}}</p>
                    <datetime-input @update="updateDeadline"></datetime-input>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Themen</label>
                    <tags-input 
                        class="mb-2"
                        :options="tags" 
                        :selected="[]" 
                        @update="updateTags"
                    ></tags-input>
                </div>

                <div class="mb-2">
                    <label class="text-gray-500 text-sm font-semibold ml-2">Was habt ihr vor?</label>

                    <text-editor 
                        class="mt-1"
                        placeholder="Erzählt etwas über ihr Projekt ..."
                        :editorId="'project-description'"
                        @update="updateProjectDescription"
                    ></text-editor>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Was braucht ihr dafür?</label>

                    <text-editor 
                        class="mt-1"
                        placeholder="Erzählt etwas über euren Bedarf ..."
                        :editorId="'need-description'"
                        @update="updateNeedDescription"
                    ></text-editor>
                </div>                
            </div>   

            <div class="flex justify-end px-5">
                <button class="btn mr-2" @click.prevent="cancel">Zurück</button>
                <button class="btn btn-yellow" type="submit">Bedarf Veröffentlichen</button>
            </div> 
        </form>        
    </div>
</template>
<script>
export default {
    props:['need', 'categories', 'needs', 'tags'],

    data(){
        return{
            form:{
                categories:null,
                title: null,
                project_description: null,
                need_description:null,
                deadline: null,
                tags: null
            },
            errors:[],
            uploadImage: false,
            imagePreview: null,
            needId: null
        }
    },

    computed:{
        imageUploadUrl(){
            return this.needId ? `/needs/${this.needId}/image` : '/';
        },

        imageSrc(){
            if(this.imagePreview){
                return this.imagePreview;
            }else if(this.need){
                return this.need.title_image;
            }
            return  '/storage/assets/default_need.png'; 
        }
    
    },

    methods:{
        updateCategories(value){
            this.form.categories = value;
        },

        updateProjectDescription(text){
            this.form.project_description = text;
        },

        updateNeedDescription(text){
            this.form.need_description = text;
        },

        updateDeadline(date){
            this.form.deadline = date;
        },

        updateTags(tags){
            this.form.tags = tags;
        },

        createNeed(){ 
            axios
                .post(`/needs/store`, this.form)
                .then((response)=>{
                    this.needId = response.data.id;

                    setTimeout(() => {
                        if(this.imagePreview){                        
                            this.uploadImage = true;    
                        }else{
                            this.redirectToNeed();
                        }
                    }, 1000);                    
                })
                .catch((errors) => {
                    this.errors = errors.response.data.errors; 
                });
        },

        cancel(){
            window.history.back();
        },

        showPreview(image){
            this.imagePreview = image;
        },  

        removePreview(){
            this.imagePreview = null;
        },

        redirectToNeed(){
            window.location.href = `/needs/${this.needId}`;
        }
    }
}
</script>