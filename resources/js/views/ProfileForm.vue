<template>

    <div>

        <div class="container mb-5 md:rounded-xl"> 
            <h4 class="text-gray-500">Was habt ihr vor?</h4>
            <div class="flex flex-col mx-auto py-2 md:w-2/3">
                <button 
                    class="border-2 text-gray-600 rounded-full py-2 mb-2 hover:text-dg-blue hover:border-dg-blue focus:outline-none"
                    :class="form.helper ? '' : 'text-dg-blue border-dg-blue'"
                    @click="form.helper = !form.helper"
                >
                    Wir suchen nach Unterstüzung
                </button>
                <button 
                    class="border-2 text-gray-600 rounded-full py-2 hover:text-dg-yellow hover:border-dg-yellow focus:outline-none"
                    :class="form.helper ? 'text-dg-yellow border-dg-yellow' : ''"
                    @click="form.helper = !form.helper"
                >
                    Wir bieten Unterstüzung an
                </button>              
                
            </div> 

            <category-select 
                class="mt-5" 
                :categories="categories" 
                :selected="user.categories" 
                v-show="form.helper"
                @update="updateCategories"
            ></category-select>                  
        </div>

        <div class="container md:rounded-xl">  
            <form @submit.prevent="submit">
                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Name / Bezeichnung</label>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.name">{{errors.name[0]}}</p>
                    <div class="input mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 256c52.805 0 96-43.201 96-96s-43.195-96-96-96-96 43.201-96 96 43.195 96 96 96zm0 48c-63.598 0-192 32.402-192 96v48h384v-48c0-63.598-128.402-96-192-96z"/></svg>
                        <input class="pl-12 pr-5"
                            type="text"
                            name="name"
                            v-model="form.name"
                            required 
                            placeholder="Name"
                        >
                    </div>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Kurzbeschreibung</label>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.excerpt">{{errors.excerpt[0]}}</p>
                    <textfield 
                        class="mt-1" 
                        :text="form.excerpt" 
                        :max-length="255"
                        placeholder="Ezählt kurz über euch ..." 
                        @input="updateExcerpt"
                    ></textfield>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Themen</label>
                    <tags-input 
                        class="mb-2"
                        :options="tags" 
                        :selected="user.tagNames" 
                        @update="updateTags"
                    ></tags-input>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Beschreibung</label>
                    <textfield 
                        class="mt-1" 
                        :text="form.description" 
                        placeholder="Ezählt etwas mehr ..." 
                        @input="updateDescription"
                    ></textfield>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Link zur Webseite</label>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.web_link">{{errors.web_link[0]}}</p>
                    <div class="input mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48C141.124 48 48 141.125 48 256s93.124 208 208 208c114.875 0 208-93.125 208-208S370.875 48 256 48zm-21.549 384.999c-39.464-4.726-75.978-22.392-104.519-50.932C96.258 348.393 77.714 303.622 77.714 256c0-42.87 15.036-83.424 42.601-115.659.71 8.517 2.463 17.648 2.014 24.175-1.64 23.795-3.988 38.687 9.94 58.762 5.426 7.819 6.759 19.028 9.4 28.078 2.583 8.854 12.902 13.498 20.019 18.953 14.359 11.009 28.096 23.805 43.322 33.494 10.049 6.395 16.326 9.576 13.383 21.839-2.367 9.862-3.028 15.937-8.13 24.723-1.557 2.681 5.877 19.918 8.351 22.392 7.498 7.497 14.938 14.375 23.111 21.125 12.671 10.469-1.231 24.072-7.274 39.117zm147.616-50.932c-25.633 25.633-57.699 42.486-92.556 49.081 4.94-12.216 13.736-23.07 21.895-29.362 7.097-5.476 15.986-16.009 19.693-24.352 3.704-8.332 8.611-15.555 13.577-23.217 7.065-10.899-17.419-27.336-25.353-30.781-17.854-7.751-31.294-18.21-47.161-29.375-11.305-7.954-34.257 4.154-47.02-1.417-17.481-7.633-31.883-20.896-47.078-32.339-15.68-11.809-14.922-25.576-14.922-42.997 12.282.453 29.754-3.399 37.908 6.478 2.573 3.117 11.42 17.042 17.342 12.094 4.838-4.043-3.585-20.249-5.212-24.059-5.005-11.715 11.404-16.284 19.803-24.228 10.96-10.364 34.47-26.618 32.612-34.047s-23.524-28.477-36.249-25.193c-1.907.492-18.697 18.097-21.941 20.859.086-5.746.172-11.491.26-17.237.055-3.628-6.768-7.352-6.451-9.692.8-5.914 17.262-16.647 21.357-21.357-2.869-1.793-12.659-10.202-15.622-8.968-7.174 2.99-15.276 5.05-22.45 8.039 0-2.488-.302-4.825-.662-7.133a176.585 176.585 0 0 1 45.31-13.152l14.084 5.66 9.944 11.801 9.924 10.233 8.675 2.795 13.779-12.995L282 87.929V79.59c27.25 3.958 52.984 14.124 75.522 29.8-4.032.361-8.463.954-13.462 1.59-2.065-1.22-4.714-1.774-6.965-2.623 6.531 14.042 13.343 27.89 20.264 41.746 7.393 14.801 23.793 30.677 26.673 46.301 3.394 18.416 1.039 35.144 2.896 56.811 1.788 20.865 23.524 44.572 23.524 44.572s10.037 3.419 18.384 2.228c-7.781 30.783-23.733 59.014-46.769 82.052z"/></svg>
                        <input class="pl-12 pr-5"
                            type="text"                           
                            v-model="form.web_link"                            
                            placeholder="https://..."
                        >
                    </div>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Link zum Facebook-Profil</label>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.facebook_link">{{errors.facebook_link[0]}}</p>
                    <div class="input mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M426.8 64H85.2C73.5 64 64 73.5 64 85.2v341.6c0 11.7 9.5 21.2 21.2 21.2H256V296h-45.9v-56H256v-41.4c0-49.6 34.4-76.6 78.7-76.6 21.2 0 44 1.6 49.3 2.3v51.8h-35.3c-24.1 0-28.7 11.4-28.7 28.2V240h57.4l-7.5 56H320v152h106.8c11.7 0 21.2-9.5 21.2-21.2V85.2c0-11.7-9.5-21.2-21.2-21.2z"/></svg>
                        <input class="pl-12 pr-5"
                            type="text"                            
                            v-model="form.facebook_link"                            
                            placeholder="https://www.facebook.com/..."
                        >
                    </div>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Link zum Instagram-Profil</label>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.instagram_link">{{errors.instagram_link[0]}}</p>
                    <div class="input mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M336 96c21.2 0 41.3 8.4 56.5 23.5S416 154.8 416 176v160c0 21.2-8.4 41.3-23.5 56.5S357.2 416 336 416H176c-21.2 0-41.3-8.4-56.5-23.5S96 357.2 96 336V176c0-21.2 8.4-41.3 23.5-56.5S154.8 96 176 96h160m0-32H176c-61.6 0-112 50.4-112 112v160c0 61.6 50.4 112 112 112h160c61.6 0 112-50.4 112-112V176c0-61.6-50.4-112-112-112z"/><path d="M360 176c-13.3 0-24-10.7-24-24s10.7-24 24-24c13.2 0 24 10.7 24 24s-10.8 24-24 24zM256 192c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64m0-32c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96z"/></svg>
                        <input class="pl-12 pr-5"
                            type="text"                            
                            v-model="form.instagram_link"                            
                            placeholder="https://www.instagram.com/..."
                        >
                    </div>
                </div>

                <div>
                    <label class="text-gray-500 text-sm font-semibold ml-2">Link zum Tweeter-Profil</label>
                    <p class="text-sm text-red-500 mb-2 ml-2" v-if="errors.twitter_link">{{errors.twitter_link[0]}}</p>
                    <div class="input mt-1">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492 109.5c-17.4 7.7-36 12.9-55.6 15.3 20-12 35.4-31 42.6-53.6-18.7 11.1-39.4 19.2-61.5 23.5C399.8 75.8 374.6 64 346.8 64c-53.5 0-96.8 43.4-96.8 96.9 0 7.6.8 15 2.5 22.1-80.5-4-151.9-42.6-199.6-101.3-8.3 14.3-13.1 31-13.1 48.7 0 33.6 17.2 63.3 43.2 80.7-16-.4-31-4.8-44-12.1v1.2c0 47 33.4 86.1 77.7 95-8.1 2.2-16.7 3.4-25.5 3.4-6.2 0-12.3-.6-18.2-1.8 12.3 38.5 48.1 66.5 90.5 67.3-33.1 26-74.9 41.5-120.3 41.5-7.8 0-15.5-.5-23.1-1.4C62.8 432 113.7 448 168.3 448 346.6 448 444 300.3 444 172.2c0-4.2-.1-8.4-.3-12.5C462.6 146 479 129 492 109.5z"/></svg>
                        <input class="pl-12 pr-5"
                            type="text"                            
                            v-model="form.twitter_link"                            
                            placeholder="https://www.twitter.com/..."
                        >
                    </div>
                </div>

                <div class="flex justify-end mt-5">
                    <button class="btn mr-2" @click.prevent="cancel">Abbrechen</button>
                    <button class="btn btn-yellow" type="submit">Ändern</button>
                </div>               

            </form>
        </div>
    </div>
    
</template>
<script>    

    export default {        

        props:[ 'user', 'categories', 'tags'],

        data(){
            return{
                form:{
                    name: this.user.name,
                    excerpt: this.user.excerpt,
                    description: this.user.description,
                    helper:this.user.helper,
                    categories: this.user.categories,
                    tags: this.user.tagNames,
                    web_link: this.user.web_link,
                    facebook_link: this.user.facebook_link,
                    instagram_link: this.user.instagram_link,
                    twitter_link: this.user.twitter_link
                },   
                
                errors:[]
            }
        },       

        methods:{
            updateExcerpt(text){             
                this.form.excerpt = text;
            },

            updateDescription(text){             
                this.form.description = text;
            },

            updateCategories(categories){
                this.form.categories = categories;
            },

            updateTags(tags){
                this.form.tags = tags; 
            },

            submit(){
                axios
                    .post(`/profiles/${this.user.username}`, this.form)
                    .then(()=>{
                        window.location.href = `/profiles/${this.user.username}`;
                    })
                    .catch((error)=>{
                        this.errors = error.response.data.errors;                        
                    });
            },
            
            cancel(){
                window.history.back();
            }
        }
        
    }   
</script>