<template>
    <div class="md:flex">
        <div
            class="w-full mb-4 md:w-1/3 px-5 cursor-pointer"
            v-for="(category, index) in categories"
            :key="index"
            @click="toggleCategory(category)"
        >
            <button 
                class="dg-category dg-category-btn mr-5 focus:outline-none" 
                :style="buttonStyles(category)"               
            >
                <p class="mr-1" v-html="category.icon"></p>
                <p v-text="category.name"></p>                        
            </button>  
            <p class="text-gray-500 text-xs mt-1" v-text="category.description" :style="buttonStyles(category)"  ></p>
        </div> 
    </div>
</template>
<script>
export default {
    props:['categories', 'selected'],

    data(){
        return{
            selectedCategories: this.selected
        }
    },

    methods:{
        buttonStyles(category){ 
            return {
                // '--category-color': category.color,
                'color': this.isSelected(category) ? category.color : ''
            }; 
        },

        isSelected(category){
            return this.selectedCategories.some(item => item.id === category.id );            
        },

        toggleCategory(category){        
            let index = this.selectedCategories.findIndex(item => item.id === category.id);

            if(index < 0){
                this.selectedCategories.push(category);
            }else{
                this.selectedCategories.splice(index, 1);
            }   
            
            this.$emit('update', this.selectedCategories);
        }

    }
    
}
</script>
<style lang="scss">
    // .dg-category-btn{
    //     &:hover{
    //         color: var(--category-color);
    //     }
    // }

</style>