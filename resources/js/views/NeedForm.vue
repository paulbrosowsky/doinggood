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
            <div class="flex text-gray-500 mb-2">
                <h4 class=" text-gray-500 mb-5">Welche Art von Untestüzung braucht ihr?</h4>
                <a class="cursor-pointer ml-2" @click="$modal.show('info-box', tagsInfo)" >
                    <svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M235 339h42v42h-42zM276.8 318h-41.6c0-67 62.4-62.2 62.4-103.8 0-22.9-18.7-41.7-41.6-41.7S214.4 192 214.4 214h-41.6c0-46 37.2-83 83.2-83s83.2 37.1 83.2 83.1c0 52-62.4 57.9-62.4 103.9z"/></svg>
                 </a>
            </div>
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
                    <div class="flex text-gray-500 mb-2">
                        <label class=" text-sm font-semibold ml-2">Überschrift</label>
                        <a class="cursor-pointer ml-2" @click="$modal.show('info-box', titleInfo)" >
                            <svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M235 339h42v42h-42zM276.8 318h-41.6c0-67 62.4-62.2 62.4-103.8 0-22.9-18.7-41.7-41.6-41.7S214.4 192 214.4 214h-41.6c0-46 37.2-83 83.2-83s83.2 37.1 83.2 83.1c0 52-62.4 57.9-62.4 103.9z"/></svg>
                        </a>
                    </div>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.title">{{errors.title[0]}}</p>
                    <div class="input mt-1">                        
                        <input class="px-3"
                            type="text"
                            name="title"
                            v-model="form.title"
                            required 
                            placeholder="Titel für euer Vorhaben"
                        >
                    </div>
                </div>

                <div class="mb-2">
                    <div class="flex text-gray-500 mb-2">
                        <label class=" text-sm font-semibold ml-2">Deadline</label>
                        <a class="cursor-pointer ml-2" @click="$modal.show('info-box', deadlineInfo)" >
                            <svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M235 339h42v42h-42zM276.8 318h-41.6c0-67 62.4-62.2 62.4-103.8 0-22.9-18.7-41.7-41.6-41.7S214.4 192 214.4 214h-41.6c0-46 37.2-83 83.2-83s83.2 37.1 83.2 83.1c0 52-62.4 57.9-62.4 103.9z"/></svg>
                        </a>
                    </div>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.deadline">{{errors.deadline[0]}}</p>
                    <datetime-input 
                        :selected="form.deadline" 
                        @update="updateDeadline"
                    ></datetime-input>
                </div>

                <div class="mb-2 ">
                    <div class="flex text-gray-500 mb-2">
                        <label class=" text-sm font-semibold ml-2">Standort</label>
                        <a class="cursor-pointer ml-2" @click="$modal.show('info-box', locationInfo)" >
                            <svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M235 339h42v42h-42zM276.8 318h-41.6c0-67 62.4-62.2 62.4-103.8 0-22.9-18.7-41.7-41.6-41.7S214.4 192 214.4 214h-41.6c0-46 37.2-83 83.2-83s83.2 37.1 83.2 83.1c0 52-62.4 57.9-62.4 103.9z"/></svg>
                        </a>
                    </div>
                    <location @change="updateLocation" :value="form.location"></location>
                </div>

                <div>
                    <div class="flex text-gray-500 mb-2">
                        <label class=" text-sm font-semibold ml-2">Themen</label>
                        <a class="cursor-pointer ml-2" @click="$modal.show('info-box', tagsInfo)" >
                            <svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M235 339h42v42h-42zM276.8 318h-41.6c0-67 62.4-62.2 62.4-103.8 0-22.9-18.7-41.7-41.6-41.7S214.4 192 214.4 214h-41.6c0-46 37.2-83 83.2-83s83.2 37.1 83.2 83.1c0 52-62.4 57.9-62.4 103.9z"/></svg>
                        </a>
                    </div>
                    <tags-input 
                        class="mb-2"
                        :options="tags" 
                        :selected="form.tags" 
                        :placeholder="'Schwerpunkt eures Vorhabens'"
                        @update="updateTags"
                    ></tags-input>
                </div>

                <div class="mb-2">
                    <div class="flex text-gray-500 mb-2">
                        <label class=" text-sm font-semibold ml-2">Was habt ihr vor?</label>
                        <a class="cursor-pointer ml-2" @click="$modal.show('info-box', descriptionInfo)" >
                            <svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M235 339h42v42h-42zM276.8 318h-41.6c0-67 62.4-62.2 62.4-103.8 0-22.9-18.7-41.7-41.6-41.7S214.4 192 214.4 214h-41.6c0-46 37.2-83 83.2-83s83.2 37.1 83.2 83.1c0 52-62.4 57.9-62.4 103.9z"/></svg>
                        </a>
                    </div>
                    <text-editor 
                        class="mt-1"
                        placeholder="Erzählt mehr über euer Vorhaben ..."
                        :editorId="'project-description'"
                        :text="form.project_description"
                        @update="updateProjectDescription"
                    ></text-editor>
                </div>

                <div>
                    <div class="flex text-gray-500 mb-2">
                        <label class=" text-sm font-semibold ml-2">Was braucht ihr dafür?</label>
                        <a class="cursor-pointer ml-2" @click="$modal.show('info-box', needDescriptionInfo)" >
                            <svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M235 339h42v42h-42zM276.8 318h-41.6c0-67 62.4-62.2 62.4-103.8 0-22.9-18.7-41.7-41.6-41.7S214.4 192 214.4 214h-41.6c0-46 37.2-83 83.2-83s83.2 37.1 83.2 83.1c0 52-62.4 57.9-62.4 103.9z"/></svg>
                        </a>
                    </div>
                    <text-editor 
                        class="mt-1"
                        placeholder="Beschreibt hier möglichst detailliert, was ihr braucht ..."
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
                tags: this.need.tagNames,
                location: this.need.location,
                lat: this.need.lat,
                lng: this.need.lng
            },
            errors:[],
            uploadImage: false,
            imagePreview: null,
            needId: this.need.id,

            needInfo:{
                title: 'Welche Art von Untestüzung braucht ihr?',
                text: `Ihr könnt hier nur eine oder mehrere Arten der Unterstützung auswählen. Wenn ihr Geld,
                        Sachen und Kompetenz benötigt, kann es aber auch sinnvoll sein, drei getrennte Bedarfe
                        anzulegen, die ihr dann weiter unten in den Beschreibungsfeldern treffender und
                        zielgenauer beschreibt.
                        „Kompetenz“ können Fähigkeiten oder Know-how sein, was ihr selbst nicht im Team habt.
                        Ihr könnt hier aber auch angeben, dass ihr einfach ein paar mehr „helfende Hände“ für eine
                        Aktion braucht.`
            },

            titleInfo:{
                title: 'Überschrift',
                text: `Beschreibt hier nicht den Bedarf sondern den Inhalt eurer Aktion oder eures Projektes. Also
                        nicht „Geld für Kinderrechtsfestival“ sondern besser „Kinderrechtsfestival“, oder nicht
                        „Fahrdienst für Bastelaktion mit Senioren“ sondern „Bastelaktion für Senioren“.`
            },

            deadlineInfo:{
                title: 'Deadline',
                text: `Die „Deadline“ beschreibt das Datum, zu dem ihr spätestens die Hilfe benötigt. Es sollten
                        mindestens 3-4 Wochen bis zum Bedarf der Hilfe bestehen. Wenn es eher ein Fortlaufender
                        Bedarf ist, könnt ihr auch ein Datum weit in der Zukunft wählen oder das Datum später auch
                        nochmals ändern.`
            },

            locationInfo:{
                title: 'Standort',
                text: `Gebt hier den Standort ein, an dem das Projekt oder die Aktion stattfindet. Das kann, muss
                        aber nicht der Standort eurer Organisation sein, wenn zum Beispiel die Aktion im
                        Nachbarort durchgeführt wird.`
            },

            tagsInfo:{
                title: 'Themen',
                text: `Wen oder was möchtet ihr mit eurem Projekt oder eurer Aktion unterstützen. Gebt hier den
                        wichtigsten Themenbereich an, also zum Beispiel „Kinderhilfe“ oder „Naturschutz“.
                        Potenzielle Förderer werden von uns automatisch benachrichtigt, wenn ihr einen Bedarf
                        einstellt, der zu ihren Interessensgebieten passt. Je weniger Themenbereiche ihr hier
                        einstellt, desto höher die Wahrscheinlichkeit eines „Matchings“. Auch deshalb ist es besser,
                        wenn ihr zum Beispiel eine SozialAG mit vielen Aktivitäten sein, mehrere Bedarfe mit
                        möglichst spezifischem Bedarf und Themenschwerpunkt hier einzustellen als alles in einer
                        Beschreibung unterzubringen.`
            },

            descriptionInfo:{
                title: 'Was habt ihr vor?',
                text: `Was ist der Inhalt eures Projektes oder eurer Aktion und was wollt ihr damit erreichen. Hier
                        solltet ihr potenzielle Förderer von eurem Vorhaben überzeugen und begeistern.`
            },

            needDescriptionInfo:{
                title: 'Was braucht ihr dafür?',
                text: `Hier sollte der Bedarf möglichst konkret beschrieben werden. Wenn ihr Geld braucht,
                        wofür? Listet die einzelnen Posten getrennt auf und verseht sie mit einer Kostenschätzung.
                        Das macht es für Förderer konkreter und sie können sich besser mit ihrer Spende
                        identifizieren. Wenn ihr Sachen benötigt, beschreibt auch, ob ihr diese abholen könnt oder
                        ob ihr darauf angewiesen seid, dass diese bei euch vorbeigebracht werden. Auch benötigte
                        Kompetenzen so konkret wie möglich beschreiben. Wenn ihr „Helfende Hände“ braucht,
                        wann benötigt ihr diese und was konkret sollen sie während der Aktion für euch tun?`
            }

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

        updateLocation(location){
            this.form.location = location.suggestion.value;
            this.form.lat = location.suggestion.latlng.lat;
            this.form.lng = location.suggestion.latlng.lng;                
        },

        submit(){
            this[this.formType]();
        },

        create(){ 
            window.loading();
            axios
                .post(`/needs/store`, this.form)
                .then((response)=>{
                    this.submitResponse(response.data);                  
                })
                .catch((errors) => {
                    window.loading();
                    this.errors = errors.response.data.errors; 
                });
        },

        edit(){
            window.loading();
            axios
                .patch(`/needs/${this.need.id}`, this.form)
                .then((response)=>{
                    this.submitResponse(response.data);  
                })
                .catch((errors) => {
                    window.loading();
                    this.errors = errors.response.data.errors; 
                });
        },

        submitResponse(need){            
            this.needId = need.id;

            setTimeout(() => {
                window.loading();
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
            window.loading();
            axios
                .delete(`/needs/${this.need.id}`)
                .then(()=>{
                    flash('Dein Bedarf wurde gelöscht.');

                    setTimeout(() => {
                        window.loading();
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
            window.loading();
            axios
                .put(`/needs/${this.need.id}/reopen`)
                .then(()=>{
                    flash('Dein Bedarf wurde wideder eröffnet.');

                    setTimeout(() => {
                        window.loading();
                        window.location.href = `/needs/${this.need.id}`
                    }, 2000); 
                });
        },
    }
}
</script>