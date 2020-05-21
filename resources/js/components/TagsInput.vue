<template>
    <multiselect 
        v-model="selectedTags"        
        :options="options"
        :multiple="true"
        :taggable="true"
        :searchable="true"
        selectLabel="auswählen"
        deselectLabel="entfernen"
        selectedLabel="gewählt"
        tagPlaceholder="Neues Thema erstellen"
        placeholder="Wähle eure Themen aus ..."
        @tag="addTags"
        @input="$emit('update', selectedTags)"
    ></multiselect>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    
    export default {
        components: { Multiselect }, 
       
        props:['options', 'selected'],

        data(){
            return{
                selectedTags: this.selected,
                selectable: this.options
            }
        },   
        
        methods:{
            addTags(tag){
                this.selectable.push(tag);
                this.selectedTags.push(tag);                
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style lang="scss">
    .multiselect__tags{
        min-height: 50px;
        background-color: #e2e8f0;
        font-size: 1em;
        border-color: #e2e8f0;
        border-radius: 0.5rem;        
        padding: 10px 40px 0 16px;
    }

    .multiselect__input{
        background:  #e2e8f0;
    }

    .multiselect__select {  
        top: 4px;
    }

    .multiselect__content-wrapper {
        border-bottom-left-radius: .5rem;
        border-bottom-right-radius: .5rem;
        z-index: 0;        
    }

    .multiselect__single {
        background: #e2e8f0;
        padding-left: 3px;
        margin-bottom: 12px;
        margin-top: 4px;
    }

    .multiselect__tag{
        background:#a0aec0;
        color: white;    
        font-size: 0.875rem; 
        font-weight: 600;      
        padding: .4rem 1.5rem .4rem  0.75rem;
        border-radius: 5rem;
    }

    .multiselect__tag-icon {
        margin-top: 3px;
        margin-right: 4px;

        &:after{
            color:white;
        }
        
        &:hover{
            background:transparent;   
        }
        &:hover::after{
            color: #f54336;
        }
    }   
       
</style>