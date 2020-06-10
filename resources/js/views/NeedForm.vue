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
                :selected="form.categories"                                 
                @update="updateCategories"
            ></category-select> 
        </div>

        <form @submit.prevent="submit">
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
                    <datetime-input 
                        :selected="form.deadline" 
                        @update="updateDeadline"
                    ></datetime-input>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Themen</label>
                    <tags-input 
                        class="mb-2"
                        :options="tags" 
                        :selected="form.tags" 
                        @update="updateTags"
                    ></tags-input>
                </div>

                <div class="mb-2">
                    <label class="text-gray-500 text-sm font-semibold ml-2">Was habt ihr vor?</label>

                    <text-editor 
                        class="mt-1"
                        placeholder="Erzählt etwas über ihr Projekt ..."
                        :editorId="'project-description'"
                        :text="form.project_description"
                        @update="updateProjectDescription"
                    ></text-editor>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Was braucht ihr dafür?</label>

                    <text-editor 
                        class="mt-1"
                        placeholder="Erzählt etwas über euren Bedarf ..."
                        :editorId="'need-description'"
                        :text="form.need_description"
                        @update="updateNeedDescription"
                    ></text-editor>
                </div> 
            
                <div class="flex justify-end mt-5">
                    <button class="btn mr-2" @click.prevent="cancel">Zurück</button>
                    <button class="btn btn-yellow" type="submit">
                        {{ formType == 'create' ? 'Bedarf Veröffentlichen' : 'Bedarf Ändern'}}                    
                    </button>
                </div> 

            </div> 
        </form>  

        <div class="container md:rounded-xl" v-if="formType == 'edit'">
            <div class="flex">
                <button type="input" class="btn btn-red w-full mr-2 md:w-auto" @click="deleteNeed"> 
                    Bedarf Löschen
                </button>
                <button class="btn" @click="reopen">Wieder eröffnen</button>
            </div>
            
        </div>

        <loading :loading="loading"></loading>      
    </div>
</template>
<script>
export default {
    props:{
        need:{
            default(){
               return {}
            }
        }, 
        categories:{
            type: Array
        },         
        tags:{
            type: Array
        }        
    },

    data(){
        return{
            form:{
                categories:this.need.categories,
                title: this.need.title,
                project_description: this.need.project_description,
                need_description:this.need.need_description,
                deadline: this.need.deadline,
                tags: this.need.tagNames
            },
            errors:[],
            uploadImage: false,
            imagePreview: null,
            needId: this.need.id,
            loading: false,
        }
    },

    computed:{
        formType(){   
            let path = window.location.pathname;     

            return path.substring(path.lastIndexOf('/') + 1);
        },

        imageUploadUrl(){
            return this.needId ? `/needs/${this.needId}/image` : '/';
        },

        imageSrc(){
            if(this.imagePreview){
                return this.imagePreview;
            }else if(this.needId){
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

        submit(){
            this[this.formType]();
        },

        create(){ 
            this.loading = true;
            axios
                .post(`/needs/store`, this.form)
                .then((response)=>{
                    this.submitResponse(response.data);                  
                })
                .catch((errors) => {
                    this.loading = false;
                    this.errors = errors.response.data.errors; 
                });
        },

        edit(){
            this.loading = true;
            axios
                .patch(`/needs/${this.need.id}`, this.form)
                .then((response)=>{
                    this.submitResponse(response.data);  
                })
                .catch((errors) => {
                    this.loading = false;
                    this.errors = errors.response.data.errors; 
                });
        },

        submitResponse(need){            
            this.needId = need.id;

            setTimeout(() => {
                this.loading = false;
                if(this.imagePreview){                        
                    this.uploadImage = true;    
                }else{
                    this.redirectToNeed();
                }
            }, 1000); 
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
        },

        deleteNeed(){
            this.$modal.show('confirm-dialog', {
                title: 'Willst du dein Bedarf wirklich löschen?',                
                handler: () => this.deleteNeedHandler()
            });
        },

        deleteNeedHandler(){
            this.loading = true;
            axios
                .delete(`/needs/${this.need.id}`)
                .then(()=>{
                    flash('Dein Bedarf wurde gelöscht.');

                    setTimeout(() => {
                        this.loading = false;
                        window.location.href = `/needs`;
                    }, 2000); 
                });
        },

        reopen(){
            this.$modal.show('confirm-dialog', {
                title: 'Willst du dein Bedarf nochmal eröffnen?',                
                handler: () => this.reopenHandler()
            });
        },

        reopenHandler(){
            this.loading = true;
            axios
                .put(`/needs/${this.need.id}/reopen`)
                .then(()=>{
                    flash('Dein Bedarf wurde wideder eröffnet.');

                    setTimeout(() => {
                        this.loading = false;
                        window.location.href = `/needs/${this.need.id}`
                    }, 2000); 
                });
        },
    }
}
</script>